<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LadderEntry;

/**
 * LadderEntrySearch represents the model behind the search form of `app\models\LadderEntry`.
 */
class LadderEntrySearch extends LadderEntry
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'team_id', 'rank_position', 'points', 'wins', 'losses', 'streak', 'last_active_at', 'created_at', 'updated_at'], 'integer'],
            [['ladder_type', 'tier'], 'safe'],
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
        $query = LadderEntry::find();

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
            'team_id' => $this->team_id,
            'rank_position' => $this->rank_position,
            'points' => $this->points,
            'wins' => $this->wins,
            'losses' => $this->losses,
            'streak' => $this->streak,
            'last_active_at' => $this->last_active_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'ladder_type', $this->ladder_type])
            ->andFilterWhere(['like', 'tier', $this->tier]);

        return $dataProvider;
    }
}
