<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "buyer_requests".
 *
 * @property int $id
 * @property int $user_id
 * @property int $main_cat_id
 * @property int $sub_cat_id
 * @property int $sub_cat_2_id
 * @property int $brand_id
 * @property int $fabric_id
 * @property int $color_id
 * @property int $measurement_id
 * @property int $quality_id 
 * @property string $image
 * @property int|null $quantity
 * @property string|null $description
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Categories $mainCat
 * @property Categories $subCat
 * @property Categories $subCat2
 * @property Colors $color
 * @property Fabrics $fabric
 * @property Measurements $measurement
 * @property Qualities $quality 
 * @property User $user
 */
class BuyerRequest extends \yii\db\ActiveRecord
{
    public $file;
    public $other_brand;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'buyer_requests';
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
            [['main_cat_id', 'sub_cat_id', 'sub_cat_2_id'], 'required'],
           [['user_id', 'main_cat_id', 'sub_cat_id', 'sub_cat_2_id', 'brand_id', 'fabric_id', 'color_id', 'measurement_id', 'quality_id', 'quantity', 'created_at', 'updated_at'], 'integer'],
           [['description'], 'string'],
           [['image'], 'string', 'max' => 255],
           [['other_brand'], 'string', 'max' => 30],
           [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
           [['main_cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['main_cat_id' => 'id']],
           [['sub_cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['sub_cat_id' => 'id']],
           [['sub_cat_2_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['sub_cat_2_id' => 'id']],
           [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::className(), 'targetAttribute' => ['color_id' => 'id']],
           [['fabric_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fabric::className(), 'targetAttribute' => ['fabric_id' => 'id']],
           [['measurement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Measurement::className(), 'targetAttribute' => ['measurement_id' => 'id']],
           [['quality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quality::className(), 'targetAttribute' => ['quality_id' => 'id']],
           [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
           'fabric_id' => 'Fabric ID',
           'color_id' => 'Color ID',
           'measurement_id' => 'Measurement ID',
           'quality_id' => 'Quality ID',
           'image' => 'Image',
           'description' => 'Description',
           'quantity' => 'Quantity',
           'created_at' => 'Created At',
           'updated_at' => 'Updated At',
       ];
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
    * Gets query for [[Color]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getColor()
   {
       return $this->hasOne(Color::className(), ['id' => 'color_id']);
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
}
