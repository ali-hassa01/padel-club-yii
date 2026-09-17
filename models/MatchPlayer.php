<?php

namespace app\models;

use yii\db\ActiveRecord;

class MatchPlayer extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%match_player}}';
    }

    public function rules()
    {
        return [
            [['match_id', 'user_id'], 'required'],
            [['match_id', 'user_id'], 'integer'],
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->joined_at = time();
        }
        return parent::beforeSave($insert);
    }
}