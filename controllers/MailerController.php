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

        if(Yii::$app->request->isPost and $model->load(Yii::$app->request->post())) {
            if($model->validate()){

                $letter = new Mailer();
                $letter->status = 0;
                $letter->attributes = $model->attributes;
                $letter->save(false);

                return $this->redirect(['setting','id'=>$letter->id]);
            }
        }
        else{
            $model->load(Yii::$app->request->get());
        }

        //Yii::$app->controller->beforeBreadcrumbs($model);

        return $this->renderIsAjax('create', compact('model'));
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
        }
        else{
            $model->attributes = $letter->attributes;
        }

        //Yii::$app->controller->beforeBreadcrumbs($model);
        $step = '_step2';
        return $this->renderIsAjax('update', compact('step','model','letter'));
    }

    public function actionSendOrder($id)
    {
        $letter = $this->findModel($id);


        //Yii::$app->controller->beforeBreadcrumbs($model);
        $step = '_step3';
        return $this->renderIsAjax('update', compact('step','letter'));
    }


    public function actionSendStart($id)
    {
        $letter = $this->findModel($id);
        $letter->status = 1;
        $letter->update(false,['status']);
    }



    public function actionSendDemo($id)
    {
        $mailer = \app\models\Mailer::findOne($id);
        $account = $mailer->account;

        $client = Clients::find()->where([
            'email'=>'nikalas9@ya.ru'
        ])->one();

        $model = new MailerData();
        $model->status = 0;
        $model->client_id = $client->id;
        $model->client_email = $client->email;
        $model->mailer_id = $mailer->id;
        $model->lang_id = $mailer->lang_id;
        $model->save(false);

        $model->senderMail($mailer);
    }

}
