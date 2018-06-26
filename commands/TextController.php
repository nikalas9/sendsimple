<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Mailer;
use app\models\MailerData;
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

        $row = MailerData::find()
            ->where([
                'status' => 0,
                'mailer_id' => $mailer->id,
            ])
            ->one();
        $row->senderMail($mailer);
        return 0;
    }
}
