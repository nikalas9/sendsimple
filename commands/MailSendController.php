<?php

namespace app\commands;

use app\models\Clients;
use app\models\ClientsBase;
use app\models\Mailer;
use app\models\MailerData;
use yii\console\Controller;
use yii\console\Exception;
use Yii;

class MailSendController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->redis->executeCommand("SET", ['mail-send_start', time()]);

        while (1) {

            gc_enable();

            Yii::$app->redis->executeCommand("SET", ['mail-send_live', time()]);
            Yii::$app->redis->executeCommand("SET", ['mail-send_status', 1]);

            $start_time = microtime(true);

            $mailer = Mailer::find()
                ->andWhere([
                    'status' => Mailer::STATE_SENDING
                ])
                ->orderBy('id asc')
                ->one();
            if($mailer){
                try {
                    $list = MailerData::find()
                        ->where([
                            'status' => 0,
                            'mailer_id' => $mailer->id,
                        ])
                        ->all();
                    if($list) {
                        Yii::$app->redis->executeCommand("SET", ['mail-send_status', 3]);
                        Yii::$app->redis->executeCommand("SET", ['mail-send_mailerId', $mailer->id]);
                        Yii::$app->redis->executeCommand("SET", ['mail-send_stack', count($list)]);
                        Yii::$app->redis->executeCommand("SET", ['mail-send_counter', 0]);
                        foreach ($list as $row) {
                            $mailerId = Yii::$app->redis->executeCommand("GET", ['mail-send_mailerId']);
                            if ($mailer->id != $mailerId) {
                               break; //pause
                            }

                            $row->senderMail($mailer);
                            Yii::$app->redis->executeCommand("INCR", ['mail-send_counter']);

                            if(Yii::$app->params['timeMailSendSleep']) {
                                sleep(Yii::$app->params['timeMailSendSleep']);
                            }
                        }
                    }
                    $mailer->status = Mailer::STATE_FINISH;
                    $mailer->save(false);
                } catch (\Exception $e) {
                    $mailer->error_message = $e->getMessage();
                    $mailer->status = Mailer::STATE_ERROR;
                    $mailer->save(false);
                }
            }

            $load_time = microtime(true) - $start_time;
            if($load_time < Yii::$app->params['timeMailSendProcess']){
                $sleep_time = Yii::$app->params['timeMailSendProcess'] - $load_time;
                //echo 'sleep' . $sleep_time . "\n";
                Yii::$app->redis->executeCommand("SET", ['mail-send_status', 2]);
                sleep($sleep_time);
            }

            gc_collect_cycles();
        }
    }
}
