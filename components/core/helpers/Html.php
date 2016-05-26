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

    public static function labelEventStatus($status)
    {
        switch($status){
            case '-1':
                return '<span class="label label-danger">CLOSE</span>';
            case '0':
                return '<span class="label label-warning">LOCK</span>';
            case '1':
                return '<span class="label label-success">OPEN</span>';
            case '10':
                return '<span class="label label-default">ARCHIVED</span>';
        }
    }

    public static function labelFixtureStatus($status)
    {
        switch($status){
            case '0':
                return '<span class="label label-default">CLOSE</span>';
            case '1':
                return '<span class="label label-success">ACTIVE</span>';
            case '2':
                return '<span class="label label-warning">NOT FOUND</span>';
            case '3':
                return '<span class="label label-warning">LOCK</span>';
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

    public static function tableLine($items,$line)
    {
        if($items){
            if(!is_array($items)){
                $items = json_decode($items,1);
            }
            $result = '<table class="table table-bordered table-condensed" style="width:auto;">';

            $result .= '<tr>';
            foreach($items as $key1 => $one){
                if(in_array($key1,$line)){
                    $result .= '<th style="text-align:center;" colspan="3">'.$key1.'</th>';
                }
            }
            $result .= '</tr>';

            $result .= '<tr>';
            foreach($items as $key1 => $one){
                if(in_array($key1,$line)){
                    foreach($one as $key2 => $two){
                        $result .= '<td align="center">'.$key2.'</td>';
                    }
                }
            }
            $result .= '</tr>';

            $result .= '<tr>';
            foreach($items as $key1 => $one){
                if(in_array($key1,$line)){
                    foreach($one as $key2 => $two){
                        $result .= '<td align="center">' . $two . '</td>>';
                    }
                }
            }
            $result .= '</tr>';

            $result .= '</table>';
            return $result;
        }
    }

    public static function tableLineEdit($model)
    {
        if($model->line){
            $items = json_decode($model->line,1);

            $result = '<table class="table table-bordered table-condensed" style="width:auto;">';
            $result .= '<tr>';
            foreach($items as $key1 => $one){
                $result .= '<th style="text-align:center;" colspan="3">'.$key1.'</th>';
            }
            $result .= '</tr>';

            $result .= '<tr>';
            foreach($items as $key1 => $one){
                foreach($one as $key2 => $two){
                    $result .= '<td align="center">'.$key2.'</td>';
                }
            }
            $result .= '</tr>';

            $result .= '<tr>';
            foreach($items as $key1 => $one){
                foreach($one as $key2 => $two){
                    $result .= '<td align="center">'
                        . \core\xeditable\XEditable::widget([
                            'url' => Url::toRoute(['update-market','id'=>$model->id]),
                            'id'=>'line_'.$key1.'_'.$key2,
                            'placement'=>'bottom',
                            'pluginOptions'=>[
                                'name'=> $key1,
                                'pk'=> $key2,
                                'value'=> $two,
                            ]
                        ]) . '</td>';
                }
            }
            $result .= '</tr>';

            $result .= '</table>';
            return $result;
        }
    }

    public static function tableSource($data,$line)
    {
        if($data){
            $items = json_decode($data,1);
            $checkFeed = \common\models\Feed::find()
                ->where([
                    'id'=>ArrayHelper::getColumn($items,'feed_id'),
                ])
                ->asArray()
                ->all();
            $checkFeedMap = ArrayHelper::map($checkFeed,'id','name');

            $result = '<table class="table table-bordered table-condensed" style="width:auto;">';
            foreach($items as $key => $row){
                $result .= '<tr>';
                $result .= '<td>'.Html::a($checkFeedMap[$row['feed_id']],['fixture/view','id'=>$row['id']],['target'=>'_blank']).'</td>';
                $result .= '<td>'.@$row['percent'].'%</td>';
                $result .= '<td>'.date("d/m/Y H:i",$row['updated_at']).'</td>';
                $result .= '<td>'.self::tableLine($row['line'],$line).self::tableValue($row['price']).'</td>';
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