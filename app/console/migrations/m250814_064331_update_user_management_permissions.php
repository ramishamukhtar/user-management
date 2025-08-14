<?php

use yii\db\Migration;

class m250814_064331_update_user_management_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Get the parent permission id for "User Management"
        $parentId = (new \yii\db\Query())
            ->select('id')
            ->from('{{%permissions}}')
            ->where(['name' => 'User Management'])
            ->scalar();

        // Insert "Users List" permission
        $this->insert('{{%permissions}}', [
            'name' => 'Users List',
            'parent_id' => $parentId,
            'route' => '/user/index',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        // Get the newly inserted permission id
        $permissionId = (new \yii\db\Query())
            ->select('id')
            ->from('{{%permissions}}')
            ->where(['name' => 'Users List'])
            ->scalar();

        // Assign this permission to admin role (role_id = 1)
        $this->insert('{{%role_permissions}}', [
            'role_id' => 1,
            'permission_id' => $permissionId,
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Remove the assignment
        $permissionId = (new \yii\db\Query())
            ->select('id')
            ->from('{{%permissions}}')
            ->where(['name' => 'Users List'])
            ->scalar();

        $this->delete('{{%role_permissions}}', ['role_id' => 1, 'permission_id' => $permissionId]);
        $this->delete('{{%permissions}}', ['id' => $permissionId]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250814_064331_update_user_management_permissions cannot be reverted.\n";

        return false;
    }
    */
}
