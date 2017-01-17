<?php
namespace core\components;


use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use Yii;

class AdminController extends BaseController
{
	/**
	 * @var ActiveRecord
	 */
	public $modelClass;

	/**
	 * @var ActiveRecord
	 */
	public $modelSearchClass;

	/**
	 * @var string
	 */
	public $scenarioOnCreate;

	/**
	 * @var string
	 */
	public $scenarioOnUpdate;

    /**
     * @var string
     */
    public $actionAfterCreate = 'index';

    /**
     * @var string
     */
    public $actionAfterUpdate = 'index';

    /**
	 * Actions that will be disabled
	 *
	 * List of available actions:
	 *
	 * ['index', 'view', 'create', 'update', 'delete', 'toggle-attribute',
	 * 'bulk-activate', 'bulk-deactivate', 'bulk-delete', 'grid-sort', 'grid-page-size']
	 *
	 * @var array
	 */
	public $disabledActions = [];

	/**
	 * Opposite to $disabledActions. Every action from AdminDefaultController except those will be disabled
	 *
	 * But if action listed both in $disabledActions and $enableOnlyActions
	 * then it will be disabled
	 *
	 * @var array
	 */
	public $enableOnlyActions = [];



    public function actions()
    {
        $implementedActions = [
            'index' => 'core\actions\IndexAction',
            'view' => 'core\actions\ViewAction',
            'create' => 'core\actions\CreateAction',
            'update' => 'core\actions\UpdateAction',
            'delete' => 'core\actions\DeleteAction',
            'toggle-attribute' => 'core\actions\ToggleAttributeAction',
            'bulk-activate' => 'core\actions\BulkActivateAction',
            'bulk-deactivate' => 'core\actions\BulkDeactivateAction',
            'bulk-delete' => 'core\actions\BulkDeleteAction',
            'grid-sort' => 'core\actions\GridSortAction',
            'grid-page-size' => 'core\actions\GridPageSizeAction',
            'grid-editable' => 'core\actions\GridEditableAction',
            'sort' => 'core\actions\SortAction',
            'select' => 'core\actions\SelectAction',
        ];
        if($this->disabledActions){
            foreach($this->disabledActions as $action){
                unset($implementedActions[$action]);
            }
        }
        if($this->enableOnlyActions){
            $new = [];
            foreach($this->enableOnlyActions as $action){
                $new[$action] = $implementedActions[$action];
            }
            $implementedActions = $new;
        }

        return $implementedActions;
    }


	public function behaviors()
	{
		return ArrayHelper::merge(parent::behaviors(),[
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		]);
	}


	/**
	 * Finds the model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param mixed $id
	 *
	 * @return ActiveRecord the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function findModel($id)
	{
		$modelClass = $this->modelClass;

		if ( ($model = $modelClass::findOne($id)) !== null )
		{
			return $model;
		}
		else
		{
			throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
		}
	}
}