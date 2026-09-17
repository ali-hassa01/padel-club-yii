<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LoyaltyLog;

/**
 * LoyaltyLogSearch represents the model behind the search form of `app\models\LoyaltyLog`.
 */
class LoyaltyLogSearch extends LoyaltyLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'reward_used', 'created_at', 'updated_at'], 'integer'],
            [['year_month', 'reward_type'], 'safe'],
            [['hours_played'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = LoyaltyLog::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'hours_played' => $this->hours_played,
            'reward_used' => $this->reward_used,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'year_month', $this->year_month])
            ->andFilterWhere(['like', 'reward_type', $this->reward_type]);

        return $dataProvider;
    }
}
