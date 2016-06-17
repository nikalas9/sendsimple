<?php
namespace core\components\gridColumns;

use Yii;

class DateRangeColumn extends DataColumn
{

    public $attribute = 'create_at';

    public $contentOptions = ['style'=>'width:200px;'];

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        $this->grid->view->registerJsFile('/web/js/plugin/bootstrap-daterangepicker/moment.min.js',['depends' => 'app\assets\AppAsset' ]);
        $this->grid->view->registerJsFile('/web/js/plugin/bootstrap-daterangepicker/daterangepicker.my.js',['depends' => 'app\assets\AppAsset' ]);
        $this->grid->view->registerCssFile('/web/js/plugin/bootstrap-daterangepicker/daterangepicker-bs3.css',['depends' => 'app\assets\AppAsset' ]);

        if($this->gridId == false) {
            $this->gridId = str_replace('/','-',Yii::$app->controller->id).'-grid';
        }
        if($this->className == false) {
            $this->className = Yii::$app->controller->modelSearchClass;
        }
        $classNameParts = explode('\\', $this->className);
        $className = end($classNameParts);

        $this->grid->view->registerJs(
            "$('#{$this->gridId}').find('input[name=\"{$className}[{$this->attribute}]\"]').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                    cancelLabel: 'Clear'
                }
            },
            'body',
            function(start, end) {
                $(this.element).trigger('change');
            });

            $('#{$this->gridId}').find('input[name=\"{$className}[{$this->attribute}]\"]').on('cancel.daterangepicker', function(ev, picker) {
                $('#{$this->gridId}').find('input[name=\"{$className}[{$this->attribute}]\"]').val('');
                $('#{$this->gridId}').find('input[name=\"{$className}[{$this->attribute}]\"]').trigger('change');
            });
        ");
    }
}