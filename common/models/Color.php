<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "colors".
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BuyerRequests[] $buyerRequests
 * @property StockQuantities[] $stockQuantities 
 */
class Color extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'colors';
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[BuyerRequests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuyerRequests()
    {
        return $this->hasMany(BuyerRequest::className(), ['color_id' => 'id']);
    }
    /**
    * Gets query for [[StockQuantities]].
    *
    * @return \yii\db\ActiveQuery
    */
    public function getStockQuantities()
    {
        return $this->hasMany(StockQuantity::className(), ['color_id' => 'id']);
    }
}
