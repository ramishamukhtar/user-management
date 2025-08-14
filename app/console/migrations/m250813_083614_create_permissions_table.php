<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%permissions}}`.
 */
class m250813_083614_create_permissions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%permissions}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'parent_id' => $this->integer()->defaultValue(null),
            'route' => $this->string(255)->defaultValue(null),            
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'deleted_at' => $this->dateTime()->defaultValue(null),
        ]);

        // Seed the database with User CRUD permissions with respective routes
        $this->batchInsert('{{%permissions}}', ['name', 'parent_id', 'route', 'created_at', 'updated_at'], [
            ['User Management', null, null, time(), time()],
            ['Create User', 1, '/user/create', time(), time()],
            ['Update User', 1, '/user/update', time(), time()],
            ['View User',   1, '/user/view',   time(), time()],
            ['Delete User', 1, '/user/delete', time(), time()],
        ]);

        // Index for performance
        $this->createIndex('idx_permissions_parent_id', '{{%permissions}}', 'parent_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%permissions}}');
    }
}
