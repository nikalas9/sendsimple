<?php

namespace core\helpers;

use yii\helpers\ArrayHelper;

class Html extends \yii\helpers\Html
{
	public static function a($text, $url = null, $options = [])
	{
        return parent::a($text, \core\helpers\Url::toRoute($url), $options);

		/*if ( in_array($url, [null, '', '#']) )
		{
			return parent::a($text, $url, $options);
		}

		return User::canRoute($url) ? parent::a($text, $url, $options) : '';*/
	}


    public static function labelStatus($status)
    {
        if($status){
            return '<span class="label label-success">Yes</span>';
        }
        else{
            return '<span class="label label-warning">No</span>';
        }
    }

    public static function preValue($data)
    {
        if($data){
            $items = json_decode($data,1);
            $result = '<pre>';
            $result .= print_r($items,1);
            $result .= '</pre>';
            return $result;
        }
    }

    public static function tableValue($items)
    {
        if($items){
            if(!is_array($items)){
                $items = json_decode($items,1);
            }
            $n = ceil(count($items)/10);
            $result = '<table class="table table-bordered table-condensed" style="width:auto;">';
            for($i=1;$i<=$n;$i++){
                $result .= '<tr>';
                $j = 1;
                foreach($items as $key => $value){
                    if((($i-1)*10<$j) and ($i*10>$j))  {
                        $result .= '<th>'.$key.'</th>';
                    }
                    $j++;
                }
                $result .= '</tr><tr>';
                $j = 1;
                foreach($items as $key => $value){
                    if((($i-1)*10<$j) and ($i*10>$j)) {
                        $result .= '<td>' . $value . '</td>>';
                    }
                    $j++;
                }
                $result .= '</tr>';
            }
            $result .= '</table>';
            return $result;
        }
    }


    public static function labelName($name)
    {
        return '<span class="label label-info">'.$name.'</span>';
    }
}