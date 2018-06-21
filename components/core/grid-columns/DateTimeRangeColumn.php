<?php

namespace core\components\gridColumns;

use Yii;

class DateTimeRangeColumn extends DataColumn
{

    public $attribute = 'create_at';


    /**
     * Init
     */
    public function init()
    {
        parent::init();

        $this->grid->view->registerJsFile('/web/js/plugin/bootstrap-daterangepicker-last/moment.min.js', ['depends' => 'app\assets\AppAsset']);
        $this->grid->view->registerJsFile('/web/js/plugin/bootstrap-daterangepicker-last/daterangepicker.js', ['depends' => 'app\assets\AppAsset']);
        $this->grid->view->registerCssFile('/web/js/plugin/bootstrap-daterangepicker-last/daterangepicker.css', ['depends' => 'app\assets\AppAsset']);

        if ($this->gridId == false) {
            $this->gridId = str_replace('/', '-', Yii::$app->controller->id) . '-grid';
        }
        if ($this->className == false) {
            $this->className = Yii::$app->controller->modelSearchClass;
        }
        $classNameParts = explode('\\', $this->className);
        $className = end($classNameParts);

        $this->grid->view->registerJs("
            var pickerObj = $('#{$this->gridId}').find('input[name=\"{$className}[{$this->attribute}]\"]');
            $(pickerObj).daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 10,
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY-MM-DD H:mm',
                    cancelLabel: 'Clear'
                }
            });
            $(pickerObj).on('apply.daterangepicker', function(ev, picker) {
                $(this).val( picker.startDate.format('YYYY-MM-DD H:mm') + ' - ' + picker.endDate.format('YYYY-MM-DD H:mm') );
                $(this).trigger('change');
            });
            $(pickerObj).on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                $(this).trigger('change');
            });
        ");

        if ($this->value == null) {
            $this->value = function ($model) {
                $attribute = $this->attribute;
                $y = date("Y", $model->$attribute);
                if ($y == date("Y")) {
                    return date("d M, H:i:s", $model->$attribute);
                } else {
                    return date("d M Y, H:i:s", $model->$attribute);
                }
            };
        }
    }
}