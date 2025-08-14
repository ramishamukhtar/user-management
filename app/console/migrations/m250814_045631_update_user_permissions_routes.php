<?php

use yii\db\Migration;

class m250814_045631_update_user_permissions_routes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Update routes for User Management permissions
        $this->update('{{%permissions}}', ['route' => '/user/create'], ['name' => 'Create User']);
        $this->update('{{%permissions}}', ['route' => '/user/update'], ['name' => 'Update User']);
        $this->update('{{%permissions}}', ['route' => '/user/view'], ['name' => 'View User']);
        $this->update('{{%permissions}}', ['route' => '/user/delete'], ['name' => 'Delete User']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Revert the routes to NULL
        $this->update('{{%permissions}}', ['route' => null], ['name' => 'Create User']);
        $this->update('{{%permissions}}', ['route' => null], ['name' => 'Update User']);
        $this->update('{{%permissions}}', ['route' => null], ['name' => 'View User']);
        $this->update('{{%permissions}}', ['route' => null], ['name' => 'Delete User']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250814_045631_update_user_permissions_routes cannot be reverted.\n";

        return false;
    }
    */
}
