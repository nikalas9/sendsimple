<?php
namespace core\components\gridColumns;

use Yii;


class SerialColumn extends \yii\grid\DataColumn
{
    public $header = '#';

    public $headerOptions = ['style'=>'width:60px'];
    public $contentOptions = ['style'=>'white-space:nowrap'];

    protected function renderDataCellContent($model, $key, $index)
    {
        $pagination = $this->grid->dataProvider->getPagination();
        if ($pagination !== false) {
            $index = $pagination->getOffset() + $index + 1;
        } else {
            $index = $index + 1;
        }
        return $index." [#{$model->primaryKey}]";
    }
}