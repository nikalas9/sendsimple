<?php

namespace app\models;

use app\models\LogAlert;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LogAlertSearch represents the model behind the search form about `app\models\base\LogAlert`.
 */
class LogAlertSearch extends LogAlert
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['log_time', 'category', 'message'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = LogAlert::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort'=>[
                'defaultOrder'=>['id'=> SORT_DESC],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($this->log_time != null) {
            list($timeFromString, $timeToString) = explode(' - ', $this->log_time);
            $timeFrom = strtotime(trim($timeFromString));
            $timeTo = strtotime(trim($timeToString));
            $query->andFilterWhere(['between', 'log_time', $timeFrom, $timeTo]);
        }

        $query->andFilterWhere(['like', 'category', $this->category]);
        $query->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
