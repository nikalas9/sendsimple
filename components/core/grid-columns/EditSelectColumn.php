<?php

namespace core\components\gridColumns;

use Yii;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\JsExpression;


class EditSelectColumn extends \core\xeditable\XEditableColumn
{
    public $dataType = 'select';
    public $format = 'raw';

    public $contentOptions = [
        'style' => 'text-align:center;'
    ];


    public function registerAssets()
    {
        $this->url = Url::toRoute(['grid-editable']);

        $source = $this->editable['source'];
        $attribute = $this->attribute;

        $this->value = function ($data) use ($source, $attribute) {
            if (isset($source[$data->$attribute])) {
                return $source[$data->$attribute];
            }
        };

        parent::registerAssets();
    }
}
