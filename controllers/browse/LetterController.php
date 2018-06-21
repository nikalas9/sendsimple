<?php

namespace app\controllers\browse;

use app\models\base\TmpLink;
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
            $mailer = $model->mailer;
            $content = $mailer->body;
            $content = $model->filterMail($content, $mailer);
            $content = $model::convertMail($content, false);
            return $this->render('view',[
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
            }
        }
        header('Content-Type: image/gif');
        header('Cache-Control: no-cache, max-age=0');

        echo base64_decode('R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw==');
    }

    public function actionRedirect($id)
    {
        $model = TmpLink::find()
            ->where([
                'hash'=>$id
            ])
            ->one();
        if($model) {
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
