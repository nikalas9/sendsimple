<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LangSearch represents the model behind the search form about `app\models\Group`.
 */
class MailerDataSearch extends MailerData
{
    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [
            [['id', 'sort', 'status'], 'integer'],
            [['name', 'main'], 'safe'],
        ];
    }*/

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
        $query = MailerData::find();

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

        // grid filtering conditions
        /*$query->andFilterWhere([
            'id' => $this->id,
            'sort' => $this->sort,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);*/

        return $dataProvider;
    }


}
