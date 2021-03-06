<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Clients;

/**
 * ClientsSearch represents the model behind the search form about `app\models\Clients`.
 */
class ClientsSearch extends Clients
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'country_id', 'city_id'], 'integer'],
            [['email', 'other', 'created_at'], 'safe'],
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
        $query = Clients::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email]);

        if($this->other){
            foreach($this->other as $alias => $value){
                if($value){
                    $value = strip_tags($value);
                    $value = htmlspecialchars($value);
                    $value = mysql_escape_string($value);
                    $query->andWhere('other REGEXP \'"'.$alias.'":"([^"]*)'.$value.'([^"]*)"\'');
                }
            }
        }

        if ($this->created_at != null) {
            $timeFrom = strtotime(substr($this->created_at, 0, 10).' 00:00:00');
            $timeTo = strtotime(substr($this->created_at, 13, 10).' 23:59:59');
            $query->andFilterWhere(['between', Clients::tableName().'.created_at', $timeFrom, $timeTo]);
        }

        return $dataProvider;
    }
}
