<?php
namespace core\components\gridColumns;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\JsExpression;


class EditCheckListColumn extends \core\xeditable\XEditableColumn
{
    public $dataType = 'checklist';
    public $format = 'raw';

    public $source = [];


    public function registerAssets()
    {
        $this->url =  Url::toRoute(['grid-editable']);

        $items = [];
        if($this->source){

            foreach($this->source as $row){
                $items[] = [
                    'value'=>$row['id'],
                    'text'=>$row['name'],
                ];
            }

            $sourceMap = ArrayHelper::map($this->source,'id','name');
            $this->filter = $sourceMap;

            $this->editable = [
                'source' => $items,
                'placement'=>'bottom'
            ];

            $attribute = $this->attribute;
            $this->value = function ($data) use ($sourceMap,$attribute) {

                $checked = explode(',',$data->$attribute);
                $items = [];
                foreach($checked as $checkId){
                    if(isset( $sourceMap[$checkId] )){
                        $items[] = $sourceMap[$checkId];
                    }
                }
                return implode('<br>',$items);
            };
        }

        parent::registerAssets();
    }
}
