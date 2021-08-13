<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories}}`.
 */
class m200508_163936_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories}}', [
            'id'            => $this->primaryKey(),
            'title'         => $this->string()->notNull(),
            'user_id'       => $this->integer()->notNull(),
            'level'         => $this->integer(1)->notNull(),
            'parent_id'     => $this->integer(),
            'description'   => $this->text(),
            'thumb'         => $this->string(),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull()
        ]);
        $this->addForeignKey("fk_categories_tbl_user_tbl", 'categories', 'user_id', 'user', 'id', "CASCADE", "RESTRICT");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey("fk_categories_tbl_user_tbl", "categories");
        $this->dropTable('{{%categories}}');
    }
}
