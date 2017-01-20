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
        $transaction = Yii::$app->db->beginTransaction();
        try
        {
            $mailer = Mailer::find()
                ->where('status = 1')
                ->orderBy('id asc')
                ->one();
            if($mailer) {
                if($mailer->base_ids){
                    $baseIds = explode(',',$mailer->base_ids);

                    $clients = Clients::find()
                        ->leftJoin(ClientsBase::tableName(),'tbl_clients_base.client_id = tbl_clients.id')
                        ->where([
                            ClientsBase::tableName().'.base_id'=>$baseIds
                        ])
                        ->all();
                    if($clients) {
                        foreach ($clients as $client) {
                            $model = new MailerData();
                            $model->status = 0;
                            $model->client_id = $client->id;
                            $uClientEmail = str_replace('@', '+'.uniqid().'@', $client->email);
                            $model->client_email = $uClientEmail;
                            $model->base_id = $baseIds[0];
                            $model->mailer_id = $mailer->id;
                            $model->lang_id = $mailer->lang_id;
                            $model->save(false);
                        }
                    }
                }
                $mailer->status = 2;
                $mailer->save(false);
            }

            $transaction->commit();
        }
        catch(Exception $e)
        {
            $transaction->rollback();
            throw $e;
        }

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
                }
            }
            $mailer->status = 3;
            $mailer->save(false);
        }
    }
}
