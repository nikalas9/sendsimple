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
        while (1) {

            gc_enable();

            $start_time = microtime(true);

            $mailer = Mailer::find()
                ->where('status = 2')
                ->orderBy('id asc')
                ->one();
            if($mailer){
                $list = MailerData::find()
                    ->where([
                        'status'=>0,
                        'mailer_id'=>$mailer->id,
                    ])
                    ->all();
                if($list) {
                    foreach ($list as $row) {
                        $row->senderMail($mailer);

                        if(Yii::$app->params['timeMailSendSleep']) {
                           sleep(Yii::$app->params['timeMailSendSleep']);
                        }
                    }
                }
                $mailer->status = 3;
                $mailer->save(false);
            }

            $load_time = microtime(true) - $start_time;
            if($load_time < Yii::$app->params['timeMailSendProcess']){
                $sleep_time = Yii::$app->params['timeMailSendProcess'] - $load_time;
                echo 'sleep' . $sleep_time . "\n";
                sleep($sleep_time);
            }

            gc_collect_cycles();
        }
    }
}
