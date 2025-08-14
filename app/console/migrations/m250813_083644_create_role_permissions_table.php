<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%role_permissions}}`.
 */
    class m250813_083644_create_role_permissions_table extends Migration
    {
        /**
         * {@inheritdoc}
         */
        public function safeUp()
        {
            $this->createTable('{{%role_permissions}}', [
                'role_id' => $this->integer()->notNull(),
                'permission_id' => $this->integer()->notNull(),
                'deleted_at' => $this->dateTime()->defaultValue(null),
                'PRIMARY KEY(role_id, permission_id)',
            ]);


            // Foreign key for role_permissions.role_id -> roles.id
            $this->addForeignKey(
                'fk-role_permissions-role_id',
                '{{%role_permissions}}',
                'role_id',
                '{{%roles}}',
                'id',
                'CASCADE'
            );

            // Foreign key for role_permissions.permission_id -> permissions.id
            $this->addForeignKey(
                'fk-role_permissions-permission_id',
                '{{%role_permissions}}',
                'permission_id',
                '{{%permissions}}',
                'id',
                'CASCADE'
            );

            // Assign all User Management Permissions to admin role (id = 1)
            $permissions = (new \yii\db\Query())
                    ->select('id')
                    ->from('{{%permissions}}')
                    ->where(['id' => 1])
                    ->orWhere(['parent_id' => 1])
                    ->all();

            foreach ($permissions as $perm) {
                $this->insert('{{%role_permissions}}', [
                    'role_id' => 1, // admin
                    'permission_id' => $perm['id'],
                ]);
            }

            // Create default Admin user
            $this->insert('{{%user}}', [
                'username' => 'Admin',
                'auth_key' => Yii::$app->security->generateRandomString(),
                'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
                'email' => 'ramishamukhtar@outlook.com',
                'status' => 10,
                'role_id' => 1,
                'created_at' => time(),
                'updated_at' => time(),
            ]);

            // Index for perofrmance
            $this->createIndex('idx_role_permissions_role_id', '{{%role_permissions}}', 'role_id');
            $this->createIndex('idx_role_permissions_permission_id', '{{%role_permissions}}', 'permission_id');

        }

        /**
         * {@inheritdoc}
         */
        public function safeDown()
        {
            $this->dropForeignKey('fk-role_permissions-role_id', '{{%role_permissions}}');
            $this->dropForeignKey('fk-role_permissions-permission_id', '{{%role_permissions}}');
            $this->delete('{{%user}}', ['username' => 'Admin']);
            $this->dropTable('{{%role_permissions}}');
        }
}
