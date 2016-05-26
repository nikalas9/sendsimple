<?php
namespace app\controllers;

use core\components\BaseController;
use Yii;


class LetterController extends BaseController
{

    public function actionBuilder($key)
    {
        $content = '';
        $style = '';

        if($body = Yii::$app->session[$key]){

            include("../components/simple_html_dom.php");
            $dom = str_get_html($body);

            $style = $dom->find('#container',0)->getAttribute('style');

            $blockList = $dom->find('.row-block');
            if($blockList){
                foreach($blockList as $row){
                    $content .= '<div class="row-block">'.$row->innertext.'</div>';
                }
            }
        }

        $this->layout = false;
        return $this->render('builder',[
            'key'=>$key,
            'style'=>$style,
            'content'=>$content,
        ]);
    }

    public function actionUpdate($key)
    {
        if(Yii::$app->request->post('content')){
            Yii::$app->session[$key] = Yii::$app->request->post('content');
        }
    }

    public function actionView($key)
    {
        if($body = Yii::$app->session[$key]){

            $cssToInlineStyles = new \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles();

            $html = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>'.$body.'<script src="/web/js/plugin/iframeResizer/iframeResizer.contentWindow.min.js"></script></body></html>';
            $css = file_get_contents( Yii::getAlias('@webroot').'/builder/css/mail.css');

            $cssToInlineStyles->setHTML($html);
            $cssToInlineStyles->setCSS($css);
            $cssToInlineStyles->setCleanup(true);

            $content = $cssToInlineStyles->convert();

            $this->layout = false;
            return $this->render('view',[
                'content'=>$content,
            ]);
        }
    }

    /*public function actionBrowse($key)
    {
        $this->layout = 'clear';

        return $this->render('elfinderBrowse',[
            'key'=>$key,
        ]);
    }*/

}
