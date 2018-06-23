<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MailerSearch represents the model behind the search form about `app\models\Mailer`.
 */
class TemplatesSearch extends Templates
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'group_id', 'lang_id'], 'integer'],
            [['name', 'created_at'], 'string'],
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
        $query = Templates::find();

        //$query->with(['countStack','countSend','countDeliver','countOpen']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort'=>[
                'defaultOrder'=>['created_at'=> SORT_DESC],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'lang_id' => $this->lang_id,
            'group_id' => $this->group_id,
        ]);

        if ($this->created_at != null) {
            $timeFrom = strtotime(substr($this->created_at, 0, 10).' 00:00:00');
            $timeTo = strtotime(substr($this->created_at, 13, 10).' 23:59:59');
            $query->andFilterWhere(['between', Mailer::tableName().'.created_at', $timeFrom, $timeTo]);
        }

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
