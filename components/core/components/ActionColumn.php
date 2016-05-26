<?php

namespace core\components;

use Yii;


class ActionColumn extends \yii\grid\ActionColumn
{

    public $template = '{view} {update} {delete}';

    public $headerOptions = ['width'=>'100px'];

    public $contentOptions = ['style'=>'text-align:center;'];

    public $buttonOptions = ['class'=>'btn btn-default btn-xs'];

    public function init()
    {
        parent::init();

        /*if( !User::canRoute( Url::toRoute('update') ) ){
            $this->template = str_replace('{update}','',$this->template);
        }
        if( !User::canRoute( Url::toRoute('delete') ) ){
            $this->template = str_replace('{delete}','',$this->template);
        }
        if( trim( $this->template ) == '' ){
            $this->visible = false;
        }*/

        /*$this->buttons['delete'] = function ($url, $model, $key) {
            $options = array_merge([
                'title' => Yii::t('yii', 'Delete'),
                'aria-label' => Yii::t('yii', 'Delete'),
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'data-method' => 'post',
                'data-pjax' => '0',
            ], $this->buttonOptions);
            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
        };*/
    }

    public function createUrl($action, $model, $key, $index)
    {
        if ($this->urlCreator instanceof Closure) {
            return call_user_func($this->urlCreator, $action, $model, $key, $index);
        } else {
            $params = is_array($key) ? $key : ['id' => (string) $key];
            $params[0] = $this->controller ? $this->controller . '/' . $action : $action;

            return \core\helpers\Url::toRoute($params);
        }
    }
}
