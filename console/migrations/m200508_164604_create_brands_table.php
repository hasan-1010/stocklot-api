<?php

use yii\db\Migration;

/**
 * Class m200508_164604_create_brands_table
 */
class m200508_164604_create_brands_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%brands}}', [
            'id'            => $this->primaryKey(),
            'title'         => $this->string(30)->notNull()->unique(),
            'logo'          => $this->string(),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%brands}}');
    }

}
