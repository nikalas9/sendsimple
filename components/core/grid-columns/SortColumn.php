<?php
namespace core\components\gridColumns;

use yii\helpers\Html;
use yii\helpers\Url;
use Yii;

//use webvimark\modules\UserManagement\models\User;
use app\models\User;

class SortColumn extends \yii\grid\DataColumn
{

    //public $attribute = 'ord';

    public $label = 'Sort';

    public $format = 'html';

    public $contentOptions = [
        'class' => 'dragHandle',
        'style'=>'width:50px; text-align:center;',
    ];

    public $gridId;

    public $sortUrl;

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        if ( !User::canRoute( Url::toRoute('bulk-deactivate') ) )
        {
            $this->visible = false;
        }
        else{

            $this->value = function ($data) {
                return Html::tag('i', '', ['class'=>'glyphicon glyphicon-resize-vertical']);
            };

            if($this->gridId == false) {
                $this->gridId = str_replace('/','-',Yii::$app->controller->id).'-grid';
            }
            if ( ! $this->sortUrl ) {
                $this->sortUrl = Url::to(['sort']);
            }


            if($this->grid->dataProvider->getModels()){

                $this->grid->view->registerJsFile('/web/js/plugin/jquery-tablednd/jquery.tablednd_0_5.js',['depends' => 'app\assets\AppAsset' ]);
                //$this->grid->view->registerJsFile('/web/js/plugin/jquery-tablednd/jquery.tablednd.0.8.min.js',['depends' => 'app\assets\AppAsset' ]); - чет неработает
                $this->grid->view->registerJs('
                $("#' . $this->gridId . ' > table").tableDnD( {
                    dragHandle: "dragHandle",
                    onDragClass: "warning",
                    onDrop: function(table, row) {
                        var rows = table.tBodies[0].rows;
                        var ords = [];
                        for (var i=0; i<rows.length; i++) {
                            ords.push( $( rows[i] ).attr("data-key") );
                        }

                        var firstord = "' . $this->grid->dataProvider->getModels()[0]->sort .'";
                        $.post("'. $this->sortUrl .'", {"firstord":firstord,"ords":ords});
                    }
                });
            ');
            }
        }

    }
}