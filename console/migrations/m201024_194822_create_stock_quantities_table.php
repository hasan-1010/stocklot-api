<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_quantities}}`.
 */
class m201024_194822_create_stock_quantities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stock_quantities}}', [
            'id'        => $this->primaryKey(),
            'stock_id'  => $this->integer()->notNull(),
            'color_id'  => $this->integer()->notNull(),
            'xsmall'    => $this->integer(),
            'small'     => $this->integer(),
            'medium'    => $this->integer(),
            'large'     => $this->integer(),
            'xlarge'    => $this->integer(),
            'xxlarge'   => $this->integer(),
            'x3large'   => $this->integer(),
            'x4large'   => $this->integer()
        ]);
        $this->addForeignKey("fk_stock_quantities_tbl_stocks_tbl", 'stock_quantities', 'stock_id', 'stocks', 'id', "CASCADE", "RESTRICT");
        $this->addForeignKey("fk_stock_quantities_tbl_colors_tbl", 'stock_quantities', 'color_id', 'colors', 'id', "CASCADE", "RESTRICT");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey("fk_stock_quantities_tbl_stocks_tbl", "stock_quantities");
        $this->dropForeignKey("fk_stock_quantities_tbl_colors_tbl", "stock_quantities");
        $this->dropTable('{{%stock_quantities}}');
    }
}
