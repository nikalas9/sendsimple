<?php

namespace core\components\formWidgets;

use yii\base\Widget;

class BaseWidget extends Widget{

    public $form;
    public $model;
    public $attribute;
    public $params;

    public $fieldOptions = [];
    public $options = [];

    public function init()
    {
        parent::init();

        $options = [];
        $fieldOptions = [];

        $model = $this->model;
        //$className = \yii\helpers\StringHelper::basename(get_class($this->model));
        //$attributeName = $this->attribute;

        if(isset($this->params['default']) and $this->params['default']){
            if($model->isNewRecord){
                $model->{$this->attribute} = $this->params['default'];
            }
        }

        if(isset($this->params['disable']) and $this->params['disable']){
            $options['disabled'] = true;
        }

        /*if(isset($this->params['remark'])){
            list($remarkClass,$remarkStatus) = explode(':',$this->params['remark']);

            $this->view->registerJs("
                $('[name=\"{$remarkClass}\"]').change(function(){
                    if( $(this).is(':checked') == {$remarkStatus} ){
                        $('[name=\"{$className}[{$attributeName}]\"]').parent().parent().removeClass('hide');
                    }
                    else{
                        $('[name=\"{$className}[{$attributeName}]\"]').parent().parent().addClass('hide');
                    }
                });
            ");
        }*/

        $this->fieldOptions = array_merge($fieldOptions,$this->fieldOptions);
        $this->options = array_merge($options,$this->options);
    }

    /*public function getSelect($modelName,$name,$params,$status = 1)
    {
        if(empty($name)) $name = 'name';

        $criteria = new CDbCriteria();
        if($status)
            $criteria->condition = 't.status = 1';

        if(isset($params['parent'])){
            $criteria->addCondition("t.id_parent = '{$params['parent']}'");
        }
        if($params['list']){
            $criteria->addCondition("t.id in ({$params['list']})");
        }

        if($this->params['tree'] and $params['list']){
            $attributeSelect = explode(',',$params['list']);
            $list = array();
            foreach($attributeSelect as $id){
                $tree = CHtml::listData(Helper::getTree($modelName,$id),'id',$name);
                $list[$id] = '/ '.implode(' / ',$tree);
            }
        }
        else{
            $list = CHtml::listData($modelName::model()->adminScope()->findAll($criteria),'id',$name);
        }
        return $list;
    }*/
}