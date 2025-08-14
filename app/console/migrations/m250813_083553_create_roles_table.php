<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%roles}}`.
 */
class m250813_083553_create_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%roles}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'deleted_at' => $this->dateTime()->defaultValue(null),        
        ]);

        $this->addForeignKey(
            'fk-user-role_id',
            '{{%user}}',
            'role_id',
            '{{%roles}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
        
        //Index for performance
        $this->createIndex('idx_user_role_id', '{{%user}}', 'role_id');
        
        // seed the database with default 2 types of users 
        $this->batchInsert('{{%roles}}', ['name', 'created_at', 'updated_at'], [
            ['admin', time(), time()],
            ['user', time(), time()],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user-role_id', '{{%user}}');
        $this->dropTable('{{%roles}}');
    }
}
