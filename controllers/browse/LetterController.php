<?php

namespace app\controllers\browse;

use app\models\base\TmpLink;
use app\models\Clients;
use app\models\MailerData;
use Yii;
use yii\web\Controller;

class LetterController extends Controller
{
    public $layout = false;

    public function actionView($id)
    {
        $model = MailerData::find()
            ->where([
                'hash'=>$id
            ])
            ->one();
        if($model) {
            if($model->open == null){
                $model->open = time();
                $model->server = json_encode($_SERVER);
                $model->update(false,['open','server']);

                $client = Clients::findOne($model->client_id);
                if ($client->status == Clients::STATE_NEW) {
                    $client->status = Clients::STATE_ACTIVE;
                    $client->update(false, ['status']);
                }
            }
            $mailer = $model->mailer;
            $content = $mailer->body;
            $content = $model->filterMail($content, $mailer);
            $content = $model::convertMail($content, false);
            return $this->render('/letter/view',[
                'content'=>$content
            ]);
        } else {
            $this->layout = 'clear';
            return $this->render('warning');
        }
    }

    public function actionOpen($id)
    {
        $model = MailerData::find()
            ->where([
                'hash'=>$id
            ])
            ->one();
        if($model) {
            if($model->open == null){
                $model->open = time();
                $model->server = json_encode($_SERVER);
                $model->update(false,['open','server']);

                $client = Clients::findOne($model->client_id);
                if ($client->status == Clients::STATE_NEW) {
                    $client->status = Clients::STATE_ACTIVE;
                    $client->update(false, ['status']);
                }
            }
        }
        header('Content-Type: image/gif');
        header('Cache-Control: no-cache, max-age=0');

        echo base64_decode('R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw==');
    }

    public function actionUnsubscribe($id)
    {
        $model = MailerData::find()
            ->where([
                'hash'=>$id
            ])
            ->one();
        if($model) {
            if($model->spam == null){
                $model->spam = time();
                $model->server = json_encode($_SERVER);
                $model->update(false,['spam','server']);

                $client = Clients::findOne($model->client_id);
                $client->status = Clients::STATE_UNSUBSCRIBE;
                $client->update(false, ['status']);

                echo 'You Unsubscribed';
                Yii::$app->end();
            }
        }
        echo 'Error: Link not found';
        Yii::$app->end();
    }

    public function actionRedirect($id)
    {
        $model = TmpLink::find()
            ->where([
                'hash'=>$id
            ])
            ->one();
        if($model) {
            if($model->open == null){
                $model->open = time();
                $model->server = json_encode($_SERVER);
                $model->update(false,['open','server']);

                $client = Clients::findOne($model->client_id);
                if ($client->status == Clients::STATE_NEW) {
                    $client->status = Clients::STATE_ACTIVE;
                    $client->update(false, ['status']);
                }
            }
            $mailerData = MailerData::findOne($model->mailer_data_id);
            if($mailerData){
                $link = json_decode($mailerData->link,1);
                $link[] = time();
                if($mailerData->open == null){
                    $mailerData->open = time();
                }
                $mailerData->link = json_encode($link);
                $mailerData->server = json_encode($_SERVER);
                $mailerData->update(false,['open','link','server']);
            }
            $this->redirect( $model->link );
        } else {
            echo 'Error: Link not found';
        }
    }
}
