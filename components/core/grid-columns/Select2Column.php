<?php
namespace core\components\gridColumns;

use Yii;

class Select2Column extends DataColumn
{
    public $gridId;

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        $this->grid->view->registerJsFile('/app/js/plugin/select2/select2.min.js',['depends' => 'app\assets\AppAsset' ]);

        if($this->gridId == false) {
            $this->gridId = str_replace('/','-',Yii::$app->controller->id).'-grid';
        }
        if($this->className == false) {
            $this->className = Yii::$app->controller->modelSearchClass;
        }
        $classNameParts = explode('\\', $this->className);
        $className = end($classNameParts);

        $this->grid->view->registerJs(
            "$('#{$this->gridId}').find('select[name=\"{$className}[{$this->attribute}]\"]').select2();"
        );
    }
}