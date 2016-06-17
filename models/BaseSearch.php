<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Base;

/**
 * BaseSearch represents the model behind the search form about `app\models\Base`.
 */
class BaseSearch extends Base
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sort', 'status', 'lang_id', 'group_id'], 'integer'],
            [['name', 'created_at'], 'safe'],
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
        $query = Base::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort'=>[
                'defaultOrder'=>['sort'=> SORT_ASC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sort' => $this->sort,
            'status' => $this->status,
            'lang_id' => $this->lang_id,
            'group_id' => $this->group_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        if ($this->created_at != null) {
            $timeFrom = strtotime(substr($this->created_at, 0, 10).' 00:00:00');
            $timeTo = strtotime(substr($this->created_at, 13, 10).' 23:59:59');
            $query->andFilterWhere(['between', Base::tableName().'.created_at', $timeFrom, $timeTo]);
        }

        return $dataProvider;
    }
}
