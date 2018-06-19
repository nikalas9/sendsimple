<?php

namespace app\commands;

use app\models\Clients;
use app\models\ClientsBase;
use app\models\Mailer;
use app\models\MailerData;
use yii\console\Controller;
use yii\console\Exception;
use Yii;

class PreContactController extends Controller
{
    public function actionIndex()
    {
        while (1) {

            gc_enable();

            $start_time = microtime(true);

            $mails = Mailer::find()
                ->andWhere([
                    'status' => Mailer::STATE_QUEUED
                ])
                ->orderBy('id asc')
                ->all();
            foreach ($mails as $mailer) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    echo 'MailerId' . $mailer->id . "\n";
                    if($mailer->base_ids){
                        $baseIds = explode(',',$mailer->base_ids);

                        $clients = Clients::find()
                            ->leftJoin(ClientsBase::tableName(),'tbl_clients_base.client_id = tbl_clients.id')
                            ->andWhere([
                                ClientsBase::tableName().'.base_id' => $baseIds
                            ])
                            ->all();
                        if($clients) {
                            foreach ($clients as $client) {
                                $model = new MailerData();
                                $model->status = 0;
                                $model->client_id = $client->id;
                                $model->client_email = $client->email;
                                $model->base_id = $baseIds[0];
                                $model->mailer_id = $mailer->id;
                                $model->lang_id = $mailer->lang_id;
                                $model->save(false);
                            }
                        }
                    }
                    $mailer->status = Mailer::STATE_SENDING;
                    $mailer->save(false);

                    $transaction->commit();
                } catch(Exception $e) {
                    $transaction->rollback();
                    throw $e;
                }
            }

            $load_time = microtime(true) - $start_time;
            if($load_time < Yii::$app->params['timePreContactProcess']){
                $sleep_time = Yii::$app->params['timePreContactProcess'] - $load_time;
                echo 'sleep' . $sleep_time . "\n";
                sleep($sleep_time);
            }

            gc_collect_cycles();
        }
    }
}
