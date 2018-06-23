<?php

namespace app\components\actions;

use core\helpers\LittleBigHelper;
use core\components\BaseAction;
use core\helpers\Url;
use Yii;

class CopyMailAction extends BaseAction
{
    public $modelTo;
    public $controllerTo = 'mailer';

    public function run($id)
    {
        $model = $this->findModel($id);

        $modelTo = $this->modelTo;
        $letter = new $modelTo;
        $letter->status = 0;
        $letter->group_id = $model->group_id;
        $letter->lang_id = $model->lang_id;
        $letter->name = $model->name;
        $letter->temp_id = uniqid();
        $letter->mode_id = $model->mode_id;
        $content = $model->body;
        $content = str_replace($model->temp_id, $letter->temp_id, $content);
        $letter->body = $content;
        $letter->save(false);

        LittleBigHelper::copy_dir('public/template/' . $model->temp_id, 'public/template/' . $letter->temp_id);

        return $this->redirect(Url::to([ $this->controllerTo . '/update', 'id'=>$letter->id]));
    }
}