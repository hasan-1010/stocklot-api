<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "stocks".
 *
 * @property int $id
 * @property int $user_id
 * @property int $main_cat_id
 * @property int $sub_cat_id
 * @property int $sub_cat_2_id
 * @property int $brand_id
 * @property int $measurement_id
 * @property int $fabric_id
 * @property int $quality_id
 * @property float $price
 * @property string|null $currency
 * @property int|null $no_of_color
 * @property int|null $quantity
 * @property int|null $gsm
 * @property string|null $description
 * @property string|null $images
 * @property string|null $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property StockQuantities[] $stockQuantities
 * @property Brands $brand 
 * @property Categories $mainCat 
 * @property Categories $subCat 
 * @property Categories $subCat2 
 * @property Fabrics $fabric 
 * @property Measurements $measurement 
 * @property Qualities $quality
 * @property User $user
 */
class Stock extends \yii\db\ActiveRecord
{
    public $files;
    public $other_brand;
    const STATUS = 'IN_STOCK';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stocks';
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_cat_id', 'sub_cat_id', 'sub_cat_2_id', 'brand_id', 'measurement_id', 'fabric_id', 'quality_id', 'price'], 'required'],
           [['user_id', 'main_cat_id', 'sub_cat_id', 'sub_cat_2_id', 'brand_id', 'measurement_id', 'fabric_id', 'quality_id', 'no_of_color', 'quantity', 'gsm', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['currency'], 'string', 'max' => 3],
            [['other_brand'], 'string', 'max' => 30],
            [['images'], 'string', 'max' => 500],
            [['status', ], 'string', 'max' => 20],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']], 
           [['main_cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['main_cat_id' => 'id']], 
           [['sub_cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['sub_cat_id' => 'id']], 
           [['sub_cat_2_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['sub_cat_2_id' => 'id']], 
           [['fabric_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fabric::className(), 'targetAttribute' => ['fabric_id' => 'id']], 
           [['measurement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Measurement::className(), 'targetAttribute' => ['measurement_id' => 'id']], 
           [['quality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quality::className(), 'targetAttribute' => ['quality_id' => 'id']], 
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['files'], 'file', 'extensions' => 'jpg, jpeg, gif, png', 'maxFiles' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'main_cat_id' => 'Main Cat ID',
            'sub_cat_id' => 'Sub Cat ID',
            'sub_cat_2_id' => 'Sub Cat 2 ID',
            'brand_id' => 'Brand ID',
            'measurement_id' => 'Measurement ID',
            'fabric_id' => 'Fabric ID',
            'quality_id' => 'Quality ID',
            'price' => 'Price',
            'currency' => 'Currency',
            'no_of_color' => 'No Of Color',
            'quantity' => 'Quantity',
            'gsm' => 'Gsm',
            'description' => 'Description',
            'images' => 'Images',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'other_brand' => "Other's Brand"
        ];
    }

    

    /**
     * Gets query for [[StockQuantities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStockQuantities()
    {
        return $this->hasMany(StockQuantity::className(), ['stock_id' => 'id']);
    }

    /**
    * Gets query for [[Brand]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getBrand()
   {
       return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
   }
   /**
    * Gets query for [[MainCat]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getMainCat()
   {
       return $this->hasOne(Category::className(), ['id' => 'main_cat_id']);
   }
   /**
    * Gets query for [[SubCat]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getSubCat()
   {
       return $this->hasOne(Category::className(), ['id' => 'sub_cat_id']);
   }
   /**
    * Gets query for [[SubCat2]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getSubCat2()
   {
       return $this->hasOne(Category::className(), ['id' => 'sub_cat_2_id']);
   }
   /**
    * Gets query for [[Fabric]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getFabric()
   {
       return $this->hasOne(Fabric::className(), ['id' => 'fabric_id']);
   }
   /**
    * Gets query for [[Measurement]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getMeasurement()
   {
       return $this->hasOne(Measurement::className(), ['id' => 'measurement_id']);
   }
   /**
    * Gets query for [[Quality]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getQuality()
   {
       return $this->hasOne(Quality::className(), ['id' => 'quality_id']);
   }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function transpose($array) {
        return array_map(null, ...$array);
    }
}
