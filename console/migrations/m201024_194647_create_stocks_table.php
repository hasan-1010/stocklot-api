<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stocks}}`.
 */
class m201024_194647_create_stocks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stocks}}', [
            'id'            => $this->primaryKey(),
            'user_id'       => $this->integer()->notNull(),
            'main_cat_id'   => $this->integer()->notNull(),
            'sub_cat_id'   => $this->integer()->notNull(),
            'sub_cat_2_id'   => $this->integer()->notNull(),
            'brand_id'      => $this->integer()->notNull(),
            'measurement_id'   => $this->integer()->notNull(),
            'fabric_id'        => $this->integer()->notNull(),
            'quality_id'       => $this->integer()->notNull(),
            'price'         => $this->decimal(11,2)->notNull(),
            'currency'      => $this->string(3),
            
            'no_of_color'   => $this->integer(2),
            
            'quantity'      => $this->integer(),
            'gsm'           => $this->integer(),
            'description'   => $this->text(),
            'images'        => $this->string(500),
            'status'        => $this->string(20),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull()
        ]);
        $this->addForeignKey("fk_stocks_tbl_user_tbl", 'stocks', 'user_id', 'user', 'id', "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_stocks_tbl_categories_tbl_1", 'stocks', 'main_cat_id', 'categories', 'id', "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_stocks_tbl_categories_tbl_2", 'stocks', 'sub_cat_id', 'categories', 'id', "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_stocks_tbl_categories_tbl_3", 'stocks', 'sub_cat_2_id', 'categories', 'id', "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_stocks_tbl_brands_tbl", 'stocks', 'brand_id', 'brands', 'id', "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_stocks_tbl_measurements_tbl", 'stocks', 'measurement_id', 'measurements', 'id', "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_stocks_tbl_fabrics_tbl", 'stocks', 'fabric_id', 'fabrics', 'id', "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_stocks_tbl_qualities_tbl", 'stocks', 'quality_id', 'qualities', 'id', "CASCADE", "RESTRICT");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey("fk_stocks_tbl_user_tbl", "stocks");
        $this->dropForeignKey("fk_stocks_tbl_categories_tbl_1", "stocks");
        $this->dropForeignKey("fk_stocks_tbl_categories_tbl_2", "stocks");
        $this->dropForeignKey("fk_stocks_tbl_categories_tbl_3", "stocks");
        $this->dropForeignKey("fk_stocks_tbl_brands_tbl", "brands");
        $this->dropForeignKey("fk_stocks_tbl_measurements_tbl", "measurements");
        $this->dropForeignKey("fk_stocks_tbl_fabrics_tbl", "fabrics");
        $this->dropForeignKey("fk_stocks_tbl_qualities_tbl", "qualities");
        $this->dropTable('{{%stocks}}');
    }
}
