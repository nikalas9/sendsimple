<?php
namespace app\controllers;

use app\models\base\Clients;
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

    public function actionSend($id)
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
