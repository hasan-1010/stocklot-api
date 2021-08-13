<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fabrics}}`.
 */
class m201024_194500_create_fabrics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fabrics}}', [
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
        $this->dropTable('{{%fabrics}}');
    }
}
