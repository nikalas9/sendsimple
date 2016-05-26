<?php

/**
 * @inheritdoc
 */

namespace core\components;

use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

use mcms\xeditable\XEditableConfig;
use mcms\xeditable\XEditableAsset;
use mcms\xeditable\XEditableColumn;


class EditableColumn extends XEditableColumn
{

    public $callbacks = [];
    public $view = null;

	/**
	 * @inheritdoc
	 */
	public function registerAssets()
	{
		$config = new XEditableConfig();

		if(isset($this->pluginOptions['mode']) && is_array($this->pluginOptions)){
			$config->mode = $this->pluginOptions['mode'];
		}

		if(isset($this->pluginOptions['form']) && is_array($this->pluginOptions)){
			$config->form = $this->pluginOptions['form'];
		}

		$config->registerDefaultAssets();

		$this->view = \Yii::$app->getView();
		XEditableAsset::register($this->view);
		//$this->editable = Json::encode($this->editable);

        $options = false;

        foreach($this->editable as $name => $value)
        {
            $options .= $name.":".Json::encode($value).",";
        }

        foreach($this->callbacks as $name => $value)
        {
            $options .= $name.":".$value.",";
        }

        if( $this->pluginOptions['id'] ) {
            $el = '#'.$this->pluginOptions['id'].' .editable[data-name=' . $this->attribute . ']';
        }
        else {
            $el = '.editable[data-name=' . $this->attribute . ']';
        }

		$this->view->registerJs('$("'.$el.'").editable({' . $options . '});');
	}

} 
