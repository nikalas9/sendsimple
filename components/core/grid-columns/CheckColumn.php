<?php
namespace core\components\gridColumns;

use yii\helpers\Html;
use Yii;


class CheckColumn extends \yii\grid\DataColumn
{

    public $format = 'html';

    public $contentOptions = ['style'=>'width:70px; text-align:center;'];

	/**
	 * Init
	 */
	public function init()
	{
		parent::init();

		$this->value = function ($data) {
            if($data->{ $this->attribute }){
                return Html::tag('i', '', ['class'=>'fa fa-check']);
            }
            else return '';
        };
	}
}