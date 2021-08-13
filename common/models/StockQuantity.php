<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock_quantities".
 *
 * @property int $id
 * @property int $stock_id
 * @property int $color_id
 * @property int|null $xsmall
 * @property int|null $small
 * @property int|null $medium
 * @property int|null $large
 * @property int|null $xlarge
 * @property int|null $xxlarge
 * @property int|null $x3large 
 * @property int|null $x4large 
 *
 * @property Colors $color
 * @property Stocks $stock
 */
class StockQuantity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock_quantities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color_id'], 'required'],
           [['stock_id', 'color_id', 'xsmall', 'small', 'medium', 'large', 'xlarge', 'xxlarge', 'x3large', 'x4large'], 'integer'],
           [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::className(), 'targetAttribute' => ['color_id' => 'id']],
           [['stock_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stock::className(), 'targetAttribute' => ['stock_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
         return [
           'id' => 'ID',
           'stock_id' => 'Stock ID',
           'color_id' => 'Color ID',
           'xsmall' => 'Xsmall',
           'small' => 'Small',
           'medium' => 'Medium',
           'large' => 'Large',
           'xlarge' => 'Xlarge',
           'xxlarge' => 'Xxlarge',
           'x3large' => '3Xlarge', 
           'x4large' => '4Xlarge', 
       ];
    }

    /** 
    * Gets query for [[Color]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getColor() 
    { 
        return $this->hasOne(Color::className(), ['id' => 'color_id']); 
    }

    /**
     * Gets query for [[Stock]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(Stock::className(), ['id' => 'stock_id']);
    }
}
