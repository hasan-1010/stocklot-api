<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%measurements}}`.
 */
class m201024_194536_create_measurements_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%measurements}}', [
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
        $this->dropTable('{{%measurements}}');
    }
}
