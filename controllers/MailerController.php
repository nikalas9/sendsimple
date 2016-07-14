<?php
namespace app\controllers;

use core\components\AdminController;
use Yii;

require_once("../components/bounceHandler/bounce_driver.class.php");

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

    public function actionRead()
    {
        echo '<pre>';

        $mailbox = yii::$app->imap->connection;

        //$mailIds = $mailbox->searchMailBox('NEW');// Prints all Mail ids.
        //print_r($mailIds);

        //$mail = $mailbox->getMail(2);
        //print_r($mail);

        $mailbox->saveMail(2);
    }

    public function actionBounce()
    {

        $bouncehandler = new \Bouncehandler();

        $bounce = file_get_contents("email.eml");
        //echo $bounce;
        //exit;

        $multiArray = @$bouncehandler->get_the_facts($bounce);

        echo '<pre>';
        print_r($multiArray);
    }

    public function actionBounce2()
    {
        require_once("../PhpBounceMailParser/Parser.php");

        // Here is a complete working example
        $parser = new \PhpBounceMailParser\Parser();
        $parser->parseFile('email.eml')
            ->outputCsv();

        print_r($parser);
        exit;

    }

}
