<?php
namespace app\controllers;

use core\components\AdminController;
use Yii;

/**
 * Site controller
 */
class MailerController extends AdminController
{
    public $modelClass = 'app\models\Mailer';

    public $modelSearchClass = 'app\models\MailerSearch';


    public function actionSend($id)
    {
        $model = \app\models\Mailer::findOne($id);
        $account = $model->account;



        $cssToInlineStyles = new \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles();

        $html = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>'.$model->body.'</body></html>';
        $css = file_get_contents( Yii::getAlias('@webroot').'/builder/css/mail.css');

        $cssToInlineStyles->setHTML($html);
        $cssToInlineStyles->setCSS($css);
        $cssToInlineStyles->setCleanup(true);

        $content = $cssToInlineStyles->convert();

        //echo $content;

        $transport = [
            'class' => 'Swift_SmtpTransport',
            'host' => $account['smtp_host'],
            'username' => $account['smtp_username'],
            'password' => $account['smtp_password'],
            'port' => $account['smtp_port'],
            'encryption' => 'ssl',
        ];

        $mailer = Yii::$app->mailer;
        $mailer->setTransport($transport);

        $result = $mailer
            ->compose()
            ->setTo('nikalas9h4dfh5f@ya.ru')
            ->setFrom([$account['from_email'] => $account['from_name']])
            ->setSubject($model->name)
            ->setHtmlBody($content)
            ->send();
        return $result;

    }
}
