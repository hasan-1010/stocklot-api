<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Stock;

/**
 * StockSearch represents the model behind the search form of `common\models\Stock`.
 */
class StockSearch extends Stock
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'main_cat_id', 'sub_cat_id', 'sub_cat_2_id', 'brand_id', 'measurement_id', 'fabric_id', 'quality_id', 'no_of_color', 'gsm', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['currency', 'brand', 'measurement', 'fabric', 'quality', 'description', 'images', 'status'], 'safe'],
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
        $query = Stock::find();

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
            'measurement_id' => $this->measurement_id,
            'fabric_id' => $this->fabric_id,
            'quality_id' => $this->quality_id,
            'price' => $this->price,
            'no_of_color' => $this->no_of_color,
            'quantity' => $this->quantity,
            'gsm' => $this->gsm,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'currency', $this->currency])
            //->andFilterWhere(['like', 'brand', $this->brand])
            //->andFilterWhere(['like', 'measurement', $this->measurement])
            //->andFilterWhere(['like', 'fabric', $this->fabric])
            //->andFilterWhere(['like', 'quality', $this->quality])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'images', $this->images])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
