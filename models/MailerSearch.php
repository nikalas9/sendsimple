<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mailer;

/**
 * MailerSearch represents the model behind the search form about `app\models\Mailer`.
 */
class MailerSearch extends Mailer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'date_create', 'user_create', 'date_update', 'user_update', 'lang_id', 'template_id', 'news_id', 'group_id', 'date_start', 'temp_id', 'max'], 'integer'],
            [['name', 'base_id', 'from_name', 'from_email', 'body', 'files'], 'safe'],
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
        $query = Mailer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
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
            'status' => $this->status,
            'date_create' => $this->date_create,
            'user_create' => $this->user_create,
            'date_update' => $this->date_update,
            'user_update' => $this->user_update,
            'lang_id' => $this->lang_id,
            'template_id' => $this->template_id,
            'news_id' => $this->news_id,
            'group_id' => $this->group_id,
            'date_start' => $this->date_start,
            'temp_id' => $this->temp_id,
            'max' => $this->max,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'base_id', $this->base_id])
            ->andFilterWhere(['like', 'from_name', $this->from_name])
            ->andFilterWhere(['like', 'from_email', $this->from_email])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'files', $this->files]);

        return $dataProvider;
    }
}
