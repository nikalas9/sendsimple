<?php

namespace app\models;

use app\models\base\TmpLink;
use yii\helpers\Url;
use Yii;

class MailerData extends \app\models\base\MailerData
{
    public $value;

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailer()
    {
        return $this->hasOne(\app\models\Mailer::className(), ['id' => 'mailer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(\app\models\Clients::className(), ['id' => 'client_id']);
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->hash = uniqid();
            }
            return true;
        }
    }

    function senderMail($mailer)
    {
        $result = $this->send($mailer);
        if($result){
            $this->send = time();
            $this->status = 1;
            $this->save(false);
        }
    }

    function send($mailer)
    {
        $account = $mailer->account;

        $eMailer = Yii::$app->mailer;
        $transport = [
            'class' => 'Swift_SmtpTransport',
            'host' => $account['smtp_host'],
            'username' => $account['smtp_username'],
            'password' => $account['smtp_password'],
            'port' => $account['smtp_port'],
            'encryption' => $account['smtp_encryption'],
        ];
        $eMailer->setTransport($transport);

        $message = $eMailer->compose();
        $header = $message->getSwiftMessage()->getHeaders();
        $unsubscribeLink = Url::toRoute(['/browse/letter/unsubscribe','id'=>$this->hash], 'http');
        $header->addTextHeader('List-Unsubscribe', '<' . $unsubscribeLink . '>');
        $msgId = $header->get('Message-ID')->getId();
        $this->message_id = $msgId;

        $content = $mailer->body;
        $content = $this->filterMail($content, $mailer);
        $content = self::convertMail($content);

        $result = $message
            ->setTo($this->client_email)
            ->setFrom([$account['from_email'] => $account['from_name']])
            ->setSubject($mailer->name)
            ->setHtmlBody($content)
            ->send();
        return $result;
    }

    function filterMail($content, $mailer)
    {
        $matchs = array();
        preg_match_all("#<a.*href=[\"'](.*)[\"'].*>(.*)</a>#isU", $content, $matchs, PREG_SET_ORDER);

        // обработка переменных в письме
        $template = new \app\components\Dextep();

        $template->setVar('group.name', $mailer->group->name);
        if($mailer->group->site){
            $template->setVar('group.name', $mailer->group->site);
        }

        $template->setVar('contact.email', $this->client->email);
        $other = array();
        if($this->client->other){
            $other = json_decode($this->client->other,1);
        }
        $clientsParam = ClientsParam::find()->active()->all();
        if($clientsParam){
            foreach($clientsParam as $row){
                if(isset($other[$row->alias]) and $other[$row->alias]){
                    $template->setVar('contact.'.$row->alias, $other[$row->alias]);
                }
            }
        }

        $webLink = Url::toRoute(['/browse/letter/view','id'=>$this->hash], 'http');
        $template->setVar('link.web', $webLink);

        $content = $template->getTemplate($content);

        // добавляем картинку отслеживания
        $imageLink = Url::toRoute(['/browse/letter/open','id'=>$this->hash], 'http');
        $content .= '<img border="0" width="1" height="1" alt="" src="'.$imageLink.'">';

        // заменяем настоящие ссылки
        if($matchs){
            foreach($matchs as $one){
                if($one[1] and !strpos($one[1],'ailto:') and !strpos($one[1],'}')){
                    $tempLink = new TmpLink();
                    $tempLink->mailer_data_id = $this->id;
                    $tempLink->link = htmlspecialchars_decode($one[1]); //чтобы повиксить возможные &amp;
                    $tempLink->hash = uniqid();
                    $tempLink->save(false);

                    $newLink = Url::toRoute(['/browse/letter/redirect','id'=>$tempLink->hash], 'http'); //Yii::$app->params['baseUrl']);
                    $content = str_replace('href="'.$one[1].'"','href="'.$newLink.'"',$content);
                }
            }
        }

        return $content;
    }

    static function convertMail($content, $clean = true){

        $cssToInlineStyles = new \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles();

        $html = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>'.$content.'</body></html>';
        $css = file_get_contents( Yii::getAlias('@app').'/web/builder/css/mail.css');

        $cssToInlineStyles->setHTML($html);
        $cssToInlineStyles->setCSS($css);
        $cssToInlineStyles->setCleanup($clean);

        return $cssToInlineStyles->convert();
    }

    // admin option ----------------------------------------------------------------------------------------------------

    public static function label($key)
    {
        $arr = [
            'list'=>'Lang',
            'action'=>'Lang',
            'model'=>'Lang',
        ];
        return $arr[$key];
    }

    public function optionIndex()
    {
        $option = [
            'items' => [
                [
                    'class' => \core\components\gridColumns\SerialColumn::className(),
                    'attribute'=>'id',
                ],
                'client_email',
                'send',
                'deliver',
                'open',
                'link',
                'error'
            ]
        ];

        return $option;
    }
}
