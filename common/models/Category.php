<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $title
 * @property int $user_id
 * @property int $level 
 * @property int|null $parent_id
 * @property string|null $description
 * @property string|null $thumb
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BuyerRequests[] $buyerRequests 
 * @property BuyerRequests[] $buyerRequests0 
 * @property BuyerRequests[] $buyerRequests1 
 * @property User $user
 * @property Stocks[] $stocks 
 * @property Stocks[] $stocks0 
 * @property Stocks[] $stocks1 
 */
class Category extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
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
            [['title', 'level'], 'required'],
            [['user_id'], 'safe'],
            [['user_id', 'level', 'parent_id', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['title', 'thumb'], 'string', 'max' => 255],
            [['file'], 'file', 'extensions' => 'gif, jpg, png, webp, jpeg'],
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
            'title' => 'Title',
            'user_id' => 'User ID',
            'level' => 'Level', 
            'parent_id' => 'Parent ID', 
            'description' => 'Description',
            'thumb' => 'Thumb',
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

    public static function getCategoryName($id){
        $model = Category::findOne($id);
        return $model->title;
    }

    public static function getLevelById($id){
        $model = Category::findOne($id);
        return $model->level;
    }

    /** 
    * Gets query for [[BuyerRequests]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getBuyerRequests() 
   { 
       return $this->hasMany(BuyerRequest::className(), ['main_cat_id' => 'id']); 
   } 
 
   /** 
    * Gets query for [[BuyerRequests0]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getBuyerRequests0() 
   { 
       return $this->hasMany(BuyerRequest::className(), ['sub_cat_id' => 'id']); 
   } 
 
   /** 
    * Gets query for [[BuyerRequests1]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getBuyerRequests1() 
   { 
       return $this->hasMany(BuyerRequest::className(), ['sub_cat_2_id' => 'id']); 
   }

   /**
    * Gets query for [[Stocks]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getStocks()
   {
       return $this->hasMany(Stock::className(), ['main_cat_id' => 'id']);
   }
   /**
    * Gets query for [[Stocks0]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getStocks0()
   {
       return $this->hasMany(Stock::className(), ['sub_cat_id' => 'id']);
   }
   /**
    * Gets query for [[Stocks1]].
    *
    * @return \yii\db\ActiveQuery
    */
   public function getStocks1()
   {
       return $this->hasMany(Stock::className(), ['sub_cat_2_id' => 'id']);
   }
}
