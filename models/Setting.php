<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Setting extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%settings}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['setting_key', 'setting_value'], 'required'],
            [['setting_key', 'description'], 'string', 'max' => 255],
            [['setting_value'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'setting_key' => 'Setting',
            'setting_value' => 'Value',
            'description' => 'Description',
        ];
    }

    /**
     * Ek value nikalne ka aasan tareeka, poori app mein kahin bhi use ho sakta hai
     */
    public static function get($key, $default = null)
    {
        $setting = self::findOne(['setting_key' => $key]);
        return $setting ? $setting->setting_value : $default;
    }
}