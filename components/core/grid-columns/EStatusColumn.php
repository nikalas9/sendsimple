<?php
namespace core\components\gridColumns;

use Yii;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\JsExpression;


class EStatusColumn extends \core\xeditable\XEditableColumn
{
    public $attribute = 'status';

    public $dataType = 'select';
    public $format = 'raw';
    public $filter = false;

    public $headerOptions = ['width'=>'60px'];
    public $contentOptions = [
        'style'=>'text-align:center;'
    ];


    public function registerAssets()
    {
        $this->url =  Url::toRoute(['editable']);

        $this->editable = [
            'source'=>[
                ['value'=>1,
                    'text'=>Yii::t('app','Да')],
                ['value'=>0,
                    'text'=>Yii::t('app','Нет')]
            ],
            'display' => new JsExpression('function(value, sourceData) {
                                var selected = $.grep(sourceData, function(o){ return value == o.value; }),
                                colors = {"1": "green", "0": "red"};
                                $(this).text(selected[0].text).css("color", colors[value]);
                            }'),
            'placement' => 'right',
        ];

        parent::registerAssets();
    }
}
