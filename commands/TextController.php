<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Mailer;
use yii\console\Controller;
use Yii;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class TextController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        $mailer = Mailer::find()
            ->andWhere([
                'status' => -1 //Mailer::STATE_SENDING
            ])
            ->orderBy('id asc')
            ->one();

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


        $content = 'test';

        $result = $message
            ->setTo('nikalas9@ya.ru')
            ->setFrom([$account['from_email'] => $account['from_name']])
            ->setSubject($mailer->name)
            ->setHtmlBody($content)
            ->send();

        return $result;
    }
}
