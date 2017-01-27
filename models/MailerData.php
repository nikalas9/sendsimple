<?php

namespace app\models;

use yii\helpers\Url;
use Yii;

class MailerData extends \app\models\base\MailerData
{
    public $value;

    function senderMail($model)
    {
        $result = $this->send($model);
        if($result){
            $this->send = time();
            $this->status = 1;
            $this->save(false);
        }
    }

    function send($model)
    {
        $account = $model->account;

        $mailer = Yii::$app->mailer;
        $transport = [
            'class' => 'Swift_SmtpTransport',
            'host' => $account['smtp_host'],
            'username' => $account['smtp_username'],
            'password' => $account['smtp_password'],
            'port' => $account['smtp_port'],
            'encryption' => $account['smtp_encryption'],
        ];
        $mailer->setTransport($transport);

        $message = $mailer->compose();
        $header = $message->getSwiftMessage()->getHeaders();
        //$header->addTextHeader('List-Unsubscribe', '<' . 'https://www.google.com.ua/' . '>');
        $msgId = $header->get('Message-ID')->getId();
        $this->message_id = $msgId;

        $content = $model->body;
        $content = $this->filterMail($content);
        $content = $this->convertMail($content);

        //$fromEmail = str_replace('@', '+'.$msgId.'@', $account['from_email']);
        $result = $message
            ->setTo($this->client_email)
            ->setFrom([$account['from_email'] => $account['from_name']])
            ->setSubject($model->name)
            ->setHtmlBody($content)
            ->send();
        return $result;
    }

    function filterMail($content)
    {
        return $content;
    }

    function createBaseUrl($group,$r,$params){
        /*$domain = Helper::getBaseUrl($group);
        return $domain.'/index.php?r='.$r.'&'.http_build_query($params);*/
    }

    function convertMail($content, $clean = true){

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
