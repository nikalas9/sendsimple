<?php

namespace core\actions;

use core\components\BaseAction;
use yii\data\ActiveDataProvider;
use Yii;

class IndexAction extends BaseAction
{
    public function run()
    {
        $searchModel  = $this->modelSearchClass ? new $this->modelSearchClass : null;

        if ( $searchModel )
        {
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        }
        else
        {
            $modelClass = $this->modelClass;
            $dataProvider = new ActiveDataProvider([
                'query' => $modelClass::find(),
                'pagination' => [
                    'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
                ],
            ]);
            $searchModel = new $modelClass;
        }

        Yii::$app->controller->beforeBreadcrumbs($searchModel);

        return $this->renderIsAjax('index', compact('dataProvider', 'searchModel'));
    }
}