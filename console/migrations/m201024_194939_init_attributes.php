<?php

use yii\db\Migration;
use common\models\Brand;
use common\models\Color;
use common\models\Measurement;
use common\models\Fabric;
use common\models\Quality;

/**
 * Class m201024_194939_init_attributes
 */
class m201024_194939_init_attributes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //add brands
        $brands = ['Adidas', 'American Eagle', 'Calvin klein', 'GAP', 'H&M', 'Jack & Jones', 'Levi’s', 'NIKE', 'Puma', 'Reebok', 'Others'];
        foreach ($brands as $key => $brand) {
            $model = new Brand();
            $model->title = $brand;
            $model->save(false);
        }
        
        //add colors
        $colors = ['Black', 'Blue', 'Olive', 'Orange', 'Pink', 'Red', 'White'];
        foreach ($colors as $key => $color) {
            $model = new Color();
            $model->name = $color;
            $model->save(false);
        }
        //add fabrics
        $fabrics = ['Knit', 'Woven'];
        foreach ($fabrics as $key => $fabric) {
            $model = new Fabric();
            $model->name = $fabric;
            $model->save(false);
        }
        //add measurement
        $measurements = ['American', 'European', 'USA'];
        foreach ($measurements as $key => $measurement) {
            $model = new Measurement();
            $model->name = $measurement;
            $model->save(false);
        }
        //add qualities
        $qualities = ['100% OK', 'Market QC'];
        foreach ($qualities as $key => $quality) {
            $model = new Quality();
            $model->name = $quality;
            $model->save(false);
        }

        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Brand::deleteAll();
        Color::deleteAll();
        Fabric::deleteAll();
        Measurement::deleteAll();
        Quality::deleteAll();
    }
}
