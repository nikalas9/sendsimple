<?php

namespace core\components;

use core\helpers\Url;
use yii\base\Action;
use Yii;

class BaseAction extends Action
{
    private $_view;


    public function getRedirectPage($action, $model)
    {
        switch ($action)
        {
            case 'delete':
                return Yii::$app->request->isAjax ? false : Url::toRoute(['index']);
                break;
            case 'update':
                return Yii::$app->request->isAjax ? false : Url::toRoute([$this->controller->actionAfterUpdate, 'id'=>$model->id]);
                break;
            case 'create':
                return Yii::$app->request->isAjax ? false : Url::toRoute([$this->controller->actionAfterCreate, 'id'=>$model->id]);
                break;
            default:
                return Url::toRoute(['index']);
        }
    }

    public function redirect($actionId = null)
    {
        if($actionId === null)
            $actionId = $this->controller->defaultAction;

        $this->controller->redirect($actionId);
    }

    public function renderIsAjax($view, $params = [])
    {
        if($this->_view === null){

            if(file_exists($this->controller->getViewPath().'/'.$view.'.php')){
                $this->_view = $view;
            }
            else{
                $this->_view = "@core/default-view/".$view;
            }
        }

        if ( Yii::$app->request->isAjax ) {
            return $this->controller->renderAjax($this->_view, $params);
        }
        else
        {
            return $this->controller->render($this->_view, $params);
        }
    }

    public function setView($value)
    {
        $this->_view = $value;
    }


    public function getModelClass()
    {
        return $this->controller->modelClass;
    }

    public function getModelSearchClass()
    {
        return $this->controller->modelSearchClass;
    }

    public function findModel($id)
    {
        return $this->controller->findModel($id);
    }
}