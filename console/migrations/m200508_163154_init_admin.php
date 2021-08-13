<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m200508_163154_init_admin
 */
class m200508_163154_init_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $model = new User();
        $model->username = "admin";
        $model->email = "admin@gmail.com";
        $model->role = 'ADMIN';
        $model->avatar = "no-image.jpg";
        $model->setPassword( "abc123" );
        $model->generateAuthKey();
        $model->save( false );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        User::deleteAll( array( 'email' => 'admin@gmail.com' ) );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200508_163154_init_admin cannot be reverted.\n";

        return false;
    }
    */
}
