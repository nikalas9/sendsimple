<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Group;

/**
 * GroupSearch represents the model behind the search form about `app\models\Group`.
 */
class GroupSearch extends Group
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sort', 'status', 'account_id'], 'integer'],
            [['name', 'site', 'domain', 'color_class', 'created_at'], 'safe'],
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
        $query = Group::find();

        $query->with(['baseExists']);

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

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sort' => $this->sort,
            'status' => $this->status,
            'account_id' => $this->account_id,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
            //'created_by' => $this->created_by,
            //'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'site', $this->site])
            ->andFilterWhere(['like', 'domain', $this->domain])
            ->andFilterWhere(['like', 'color_class', $this->color_class]);

        if ($this->created_at != null) {
            $timeFrom = strtotime(substr($this->created_at, 0, 10).' 00:00:00');
            $timeTo = strtotime(substr($this->created_at, 13, 10).' 23:59:59');
            $query->andFilterWhere(['between', Group::tableName().'.created_at', $timeFrom, $timeTo]);
        }

        return $dataProvider;
    }


}
