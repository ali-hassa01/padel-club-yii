<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GameMatch;

/**
 * GameMatchSearch represents the model behind the search form of `app\models\GameMatch`.
 */
class GameMatchSearch extends GameMatch
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'booking_id', 'created_by', 'court_id', 'slots_needed', 'created_at', 'updated_at'], 'integer'],
            [['match_date', 'start_time', 'end_time', 'skill_level', 'status'], 'safe'],
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
        $query = GameMatch::find();

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
            'booking_id' => $this->booking_id,
            'created_by' => $this->created_by,
            'match_date' => $this->match_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'court_id' => $this->court_id,
            'slots_needed' => $this->slots_needed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'skill_level', $this->skill_level])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
