<?php
namespace app\controllers;

use app\models\MailerData;
use core\components\BaseController;
use Yii;

class LetterController extends BaseController
{
    public function beforeAction($action)
    {
        if (Yii::$app->getModule('debug')) {
            Yii::$app->getModule('debug')->instance->allowedIPs = [];
        }
        return parent::beforeAction($action);
    }

    public function actionUpdate($key)
    {
        if(Yii::$app->request->post('content')){
            Yii::$app->session[$key] = Yii::$app->request->post('content');
        }
    }

    public function actionBuilder($key)
    {
        $content = '';
        $style = '';

        if($html = Yii::$app->session[$key]){

            //include("../components/simple_html_dom.php");
            //$dom = str_get_html($body);
            $dom = \SimpleHtmlDom\str_get_html($html);

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

    public function actionNicEdit($key)
    {
        $content = Yii::$app->session[$key];

        $this->layout = 'clear';
        return $this->render('nicEdit',[
            'key'=>$key,
            'content'=>$content,
        ]);
    }

    public function actionView($key)
    {
        if($body = Yii::$app->session[$key]){

            $html = MailerData::convertMail($body, true);

            $pos1 = mb_strpos($html, '<body>', 0, 'utf-8');
            $pos2 = mb_strpos($html, '</body>', 0, 'utf-8');
            if ($pos1 and $pos2) {
                $content = mb_substr($html, $pos1+6, $pos2 - ($pos1+6), 'utf-8');
            } else {
                $content = $html;
            }

            $this->layout = 'clear';
            return $this->render('view',[
                'key'=>$key,
                'content'=>$content,
            ]);
        }
    }

    public function actionPreview($key)
    {
        if ($data = Yii::$app->request->post('data')) {
            if(strpos($data,';base64')){
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
            }
            $data = base64_decode($data);

            $dirPath = 'public/template/' . $key;
            if (is_dir($dirPath) == false) {
                mkdir($dirPath, 0700);
            }
            $fileName = 'preview.jpg';
            file_put_contents($dirPath.'/'.$fileName, $data);
            Yii::$app->end();
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
