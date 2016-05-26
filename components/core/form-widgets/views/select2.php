<?php

$className = \yii\helpers\StringHelper::basename(get_class($model));
if(isset($options['multiple']) and $options['multiple']){
    $this->registerJs("
        $('[name=\"{$className}[{$attribute}][]').select2();
    ");
}
else{
    $this->registerJs("
        $('[name=\"{$className}[{$attribute}]').select2();
    ");
}

echo $form->field($model, $attribute, $fieldOptions)->dropDownList($data,$options);