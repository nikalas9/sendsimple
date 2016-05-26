<?php

namespace core\components;

//use webvimark\modules\UserManagement\components\GhostAccessControl;
use Yii;
use app\components\Controller;

class BaseController extends Controller
{
	/**
	 * @return array
	 */
	/*public function behaviors()
	{
		return [
			'ghost-access'=> [
				'class' => GhostAccessControl::className(),
			],
		];
	}*/


    public function beforeBreadcrumbs($model)
    {
        if(isset($model::$breadcrumbsKeys)){
            $breadcrumbsKeys = $model::$breadcrumbsKeys;
        }

        $className = \yii\helpers\StringHelper::basename($model::className());
        if($filters =  Yii::$app->request->get($className)){
            foreach($filters as $key => $value) {

                if(isset($breadcrumbsKeys[$key]) and $breadcrumbsKeys[$key] and $value) {

                    $modelName = $breadcrumbsKeys[$key]['m'];
                    $controllerName = $breadcrumbsKeys[$key]['c'];

                    Yii::$app->controller->view->params['breadcrumbs'][] = ['label' => $modelName::label('list'), 'url' => [$controllerName.'/index']];

                    $model = $modelName::findOne($value);
                    Yii::$app->controller->view->params['breadcrumbs'][] = ['label' => $model->name, 'url' => [$controllerName.'/view','id'=>$model->id]];
                }
            }
        }
    }
}