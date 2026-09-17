<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "court".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string|null $surface_type
 * @property int $has_lighting
 * @property float $price_per_slot
 * @property string|null $image
 * @property string|null $description
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Court extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function tableName()
    {
        return '{{%court}}';
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
            [['name', 'type'], 'required'],
            [['has_lighting', 'status'], 'integer'],
            [['price_per_slot'], 'number'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['type', 'surface_type'], 'string', 'max' => 50],
            [['image'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Court Name',
            'type' => 'Type (Indoor/Outdoor)',
            'surface_type' => 'Surface Type',
            'has_lighting' => 'Has Lighting',
            'price_per_slot' => 'Price Per Slot',
            'image' => 'Image',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}