<?php
namespace app\controllers;

use app\models\Clients;
use app\models\Mailer;
use app\models\MailerData;
use core\components\AdminController;
use Yii;

/**
 * Site controller
 */
class MailerController extends AdminController
{
    public $modelClass = 'app\models\Mailer';

    public $modelSearchClass = 'app\models\MailerSearch';

    public $disabledActions = ['create','update'];

    public function actionCreate()
    {
        $model = new \app\models\MailCreateForm();

        if (Yii::$app->request->isPost
            and $model->load(Yii::$app->request->post())) {
            if($model->validate()){

                $letter = new Mailer();
                $letter->status = Mailer::STATE_DRAFT;
                $letter->attributes = $model->attributes;
                $letter->save(false);

                return $this->redirect(['setting','id'=>$letter->id]);
            }
        } else {
            $model->load(Yii::$app->request->get());
        }

        return $this->renderIsAjax('create', compact('model'));
    }

    public function actionUpdate($id)
    {
        $letter = $this->findModel($id);
        $model = new \app\models\MailCreateForm();

        if (Yii::$app->request->isPost
            and $model->load(Yii::$app->request->post())) {
            if($model->validate()){

                $letter->attributes = $model->attributes;
                $letter->update(false);

                return $this->redirect(['setting','id'=>$letter->id]);
            }
        } else {
            $model->attributes = $letter->attributes;
        }

        $step = '_step1';
        return $this->renderIsAjax('update', compact('step','model', 'letter'));
    }


    public function actionSetting($id)
    {
        $letter = $this->findModel($id);
        $model = new \app\models\MailSettingForm();

        if(Yii::$app->request->isPost and $model->load(Yii::$app->request->post())) {
            if($model->validate()){

                $letter->attributes = $model->attributes;
                $letter->update(false);

                return $this->redirect(['send-order','id'=>$letter->id]);
            }
        } else {
            $model->attributes = $letter->attributes;
        }

        $step = '_step2';
        return $this->renderIsAjax('update', compact('step','model','letter'));
    }

    public function actionSendOrder($id)
    {
        $letter = $this->findModel($id);

        $step = '_step3';
        return $this->renderIsAjax('update', compact('step','letter'));
    }

    public function actionSendStart($id)
    {
        $letter = $this->findModel($id);
        $letter->status = 1;
        $letter->update(false,['status']);

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSendDemo($id)
    {
        $letter = $this->findModel($id);

        if ($email = Yii::$app->request->post('testEmail')) {

            $client = Clients::find()
                ->where([
                    'email' => $email
                ])
                ->one();
            if ($client == null) {
                $client = new Clients;
                $client->email = $email;
                $client->save(false);
            }

            $model = new MailerData();
            $model->status = 0;
            $model->client_id = $client->id;
            $model->client_email = $client->email;
            $model->mailer_id = $letter->id;
            $model->lang_id = $letter->lang_id;
            $model->save(false);

            $model->senderMail($letter);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionState($id)
    {
        $letter = $this->findModel($id);

        $step = '_step4';
        return $this->renderIsAjax('update', compact('step','letter'));
    }
}
