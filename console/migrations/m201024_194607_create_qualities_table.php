<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%qualities}}`.
 */
class m201024_194607_create_qualities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%qualities}}', [
            'id'            => $this->primaryKey(),
            'name'         => $this->string(30)->notNull()->unique(),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%qualities}}');
    }
}
