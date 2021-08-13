<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%buyer_requests}}`.
 */
class m201024_194901_create_buyer_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%buyer_requests}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'main_cat_id' => $this->integer()->notNull(),
            'sub_cat_id' => $this->integer()->notNull(),
            'sub_cat_2_id' => $this->integer()->notNull(),
            'brand_id' => $this->integer()->notNull(),
            'fabric_id' => $this->integer()->notNull(),
            'color_id' => $this->integer()->notNull(),
            'measurement_id' => $this->integer()->notNull(),
            'quality_id' => $this->integer()->notNull(),
            'image' => $this->string()->notNull(),
            'description' => $this->text(),
            'quantity' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
        $this->addForeignKey("fk_buyer_requests_tbl_user_tbl", 'buyer_requests', 'user_id', 'user', 'id', "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_buyer_requests_tbl_category_tbl1", 'buyer_requests', 'main_cat_id', 'categories', 'id', "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_buyer_requests_tbl_category_tbl2", 'buyer_requests', 'sub_cat_id', 'categories', 'id', "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_buyer_requests_tbl_category_tbl3", 'buyer_requests', 'sub_cat_2_id', 'categories', 'id', "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_buyer_requests_tbl_brands_tbl", 'buyer_requests', 'brand_id', 'brands', 'id', "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_buyer_requests_tbl_measurements_tbl", 'buyer_requests', 'measurement_id', 'measurements', 'id', "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_buyer_requests_tbl_fabrics_tbl", 'buyer_requests', 'fabric_id', 'fabrics', 'id', "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_buyer_requests_tbl_qualities_tbl", 'buyer_requests', 'quality_id', 'qualities', 'id', "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_buyer_requests_tbl_colors_tbl", 'buyer_requests', 'color_id', 'colors', 'id', "CASCADE", "RESTRICT");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey("fk_buyer_requests_tbl_user_tbl", "buyer_requests");
        $this->dropForeignKey("fk_buyer_requests_tbl_category_tbl1", "buyer_requests");
        $this->dropForeignKey("fk_buyer_requests_tbl_category_tbl2", "buyer_requests");
        $this->dropForeignKey("fk_buyer_requests_tbl_category_tbl3", "buyer_requests");
        $this->dropForeignKey("fk_buyer_requests_tbl_brands_tbl", "brands");
        $this->dropForeignKey("fk_buyer_requests_tbl_measurements_tbl", "measurements");
        $this->dropForeignKey("fk_buyer_requests_tbl_colors_tbl", "colors");
        $this->dropForeignKey("fk_buyer_requests_tbl_qualities_tbl", "qualities");
        $this->dropForeignKey("fk_buyer_requests_tbl_fabrics_tbl", "fabrics");
        $this->dropTable('{{%buyer_requests}}');
    }
}
