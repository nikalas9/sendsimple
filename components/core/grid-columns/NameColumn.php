<?php
namespace core\components\gridColumns;

use core\helpers\Html;
use Yii;


class NameColumn extends DataColumn
{

    public $attribute = 'name';

    public $format = 'raw';

	/**
	 * Init
	 */
	public function init()
	{
		parent::init();

		$this->value = function ($data) {
            return Html::a($data->{$this->attribute}, ['update', 'id' => $data->id], ['data-pjax'=>0], true);
        };
	}
}