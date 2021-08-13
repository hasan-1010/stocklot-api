<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BuyerRequest;

/**
 * BuyerRequestSearch represents the model behind the search form of `common\models\BuyerRequest`.
 */
class BuyerRequestSearch extends BuyerRequest
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'main_cat_id', 'sub_cat_id', 'sub_cat_2_id', 'brand_id', 'fabric_id', 'color_id', 'measurement_id', 'quality_id', 'quantity', 'created_at', 'updated_at'], 'integer'],
           [['image', 'description'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BuyerRequest::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'main_cat_id' => $this->main_cat_id,
            'sub_cat_id' => $this->sub_cat_id,
            'sub_cat_2_id' => $this->sub_cat_2_id,
            'brand_id' => $this->brand_id, 
            'fabric_id' => $this->fabric_id, 
            'color_id' => $this->color_id, 
            'measurement_id' => $this->measurement_id, 
            'quality_id' => $this->quality_id, 
            'quantity' => $this->quantity,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'brand', $this->brand]);

        return $dataProvider;
    }
}
