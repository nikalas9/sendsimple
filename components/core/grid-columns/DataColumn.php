<?php
namespace core\components\gridColumns;

use yii\helpers\Url;
use Yii;

class DataColumn extends \yii\grid\DataColumn
{
    public $autocomplete = false;
    public $autocompleteRoute = false;

    public $gridId;

    public $className;


    public function init()
    {
        parent::init();

        if($this->autocomplete){

            $this->grid->view->registerJsFile('/web/js/plugin/jQuery-Autocomplete/jquery.autocomplete.min.js',['depends' => 'app\assets\AppAsset' ]);

            if($this->gridId == false) {
                $this->gridId = str_replace('/','-',Yii::$app->controller->id).'-grid';
            }
            if($this->className == false) {
                $this->className = Yii::$app->controller->modelSearchClass;
            }
            $classNameParts = explode('\\', $this->className);
            $className = end($classNameParts);

            if($this->autocompleteRoute){
                $link = Url::to([$this->autocompleteRoute,'attribute'=>'name']);
            }
            else{
                $link = Url::to(['select','attribute'=>$this->attribute]);
            }
            $this->grid->view->registerJs("
            $('#{$this->gridId}').find('input[name=\"{$className}[{$this->attribute}]\"]').autocomplete({
                serviceUrl: '".$link."',
                dataType: 'json',
                onSelect: function(){
                    $(this).trigger('change');
                }
            });");
        }
    }
}