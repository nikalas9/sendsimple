<?php
namespace app\controllers;

use app\models\Clients;
use app\models\ClientsBase;
use app\models\Files;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\web\UploadedFile;
use core\components\AdminController;
use Yii;

/**
 * Site controller
 */
class ImportController extends AdminController
{
    public $modelClass = 'app\models\Files';

    public $modelSearchClass = 'app\models\FilesSearch';

    public $disabledActions = ['create','update'];


    public function actionCreate() {

        $model = new Files();
        $model->scenario = 'create';

        if(Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->validate()){

                $model->name = $model->file->name;
                $model->file->name = Yii::$app->security->generateRandomString(). '.' . $model->file->extension;
                if($model->save()) {
                    $model->file->saveAs('public/import/'. $model->file->name);

                    return $this->redirect(['update','id'=>$model->id]);
                }
            }
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('_form', [
                'model' => $model
            ]);
        }
        else{
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }


    public function actionUpdate($id) {

        $model = $this->findModel($id);
        $model->scenario = 'update';

        $objPHPExcel = \PHPExcel_IOFactory::load( 'public/import/'.$model->file );
        $objPHPExcel->setActiveSheetIndex(0);
        $listData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

        if ( $model->load(Yii::$app->request->post()) && $model->validate())
        {

            $columns = $model->column;
            $columns = array_diff($columns,['']);
            $emailKey = array_keys($columns,'email');
            $emailColumn = $emailKey[0];
            unset($columns[$emailColumn]);

            $iTotal = 0;
            $iCreate = 0;
            $iUpdate = 0;
            $iDub = 0;

            $uniqEmail = [];

            foreach($listData as $line){

                $email = trim($line[$emailColumn]);
                if(filter_var($email,FILTER_VALIDATE_EMAIL)){

                    $iTotal++;
                    if(in_array($email,$uniqEmail)){
                        $iDub++;
                    }
                    else{
                        array_push($uniqEmail,$email);
                    }

                    $client = Clients::find()
                        ->where([
                            'email'=>$email
                        ])
                        ->one();

                    if($client == null){

                        $client = new Clients;
                        $client->email = $email;
                        if($columns){
                            $other = [];
                            foreach($columns as $key => $column){
                                $value = trim(str_replace("_x000D_",", ",trim($line[$key])));
                                if($value){
                                    $other[$column] = $value;
                                }
                            }
                            $client->other = json_encode($other,256);
                        }
                        $client->save(false);

                        $clientBase = new ClientsBase();
                        $clientBase->status = 0;
                        $clientBase->base_id = $model->base_id;
                        $clientBase->client_id = $client->id;
                        $clientBase->file_id = $model->id;
                        $clientBase->save(false);

                        $iCreate++;
                    }
                    else{

                        if($columns){
                            $other = json_decode($client->other,1);
                            foreach($columns as $key => $column){
                                $value = trim(str_replace("_x000D_",", ",trim($line[$key])));
                                if($value and empty($other[$column])){
                                    $other[$column] = $value;
                                }
                            }
                            $client->other = json_encode($other,256);
                            $client->save(false);
                        }

                        $clientBase = ClientsBase::find()
                            ->where([
                                'base_id' => $model->base_id,
                                'client_id' => $client->id,
                            ])
                            ->one();
                        if($clientBase == null){
                            $clientBase = new ClientsBase();
                            $clientBase->status = 0;
                            $clientBase->base_id = $model->base_id;
                            $clientBase->client_id = $client->id;
                            $clientBase->file_id = $model->id;
                            $clientBase->save(false);

                            $iUpdate++;
                        }
                    }
                }
            }
            $model->status = 1;
            $model->column = json_encode($model->column);
            $model->result = json_encode([
                'total'=>$iTotal,
                'created'=>$iCreate,
                'updated'=>$iUpdate,
                'dub'=>$iDub,
            ]);
            $model->update(false);

            return $this->redirect(['view','id'=>$model->id]);
        }

        Yii::$app->controller->beforeBreadcrumbs($model);

        return $this->renderIsAjax('update', [
            'model'=>$model,
            'listData'=>$listData
        ]);
    }

}
