<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "brands".
 *
 * @property int $id
 * @property string $title
 * @property string|null $logo
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BuyerRequests[] $buyerRequests
 * @property Stocks[] $stocks
 */
class Brand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brands';
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
            [['title'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'logo'], 'string', 'max' => 30],
            [['title'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'logo' => 'Logo',
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
        return $this->hasMany(BuyerRequest::className(), ['brand_id' => 'id']);
    }

    /**
     * Gets query for [[Stocks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['brand_id' => 'id']);
    }
}
