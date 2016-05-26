<?php
namespace core\components\gridColumns;

use Yii;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\JsExpression;


class EditColumn extends \core\xeditable\XEditableColumn
{
    public $dataType = 'text';
    public $format = 'raw';

    public $contentOptions = [
        'style'=>'text-align:center;'
    ];


    public function registerAssets()
    {
        $this->url =  Url::toRoute(['grid-editable']);

        parent::registerAssets();
    }
}
