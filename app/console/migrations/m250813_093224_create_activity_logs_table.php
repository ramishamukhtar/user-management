<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%activity_logs}}`.
 */
class m250813_093224_create_activity_logs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('{{%activity_logs}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'action' => $this->string(100)->notNull()->comment('e.g., create, update, delete'),
            'entity_type' => $this->string(100)->notNull()->comment('Model/Table name'),
            'entity_id' => $this->integer()->notNull(),
            'ip_address' => $this->string(45)->null(),
            'user_agent' => $this->string(255)->null(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'deleted_at' => $this->timestamp()->null(),
        ]);

        // Foreign key to user table
        $this->addForeignKey(
            'fk_activity_logs_user',
            '{{%activity_logs}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Indexes for performance
        $this->createIndex('idx_activity_logs_user_id', '{{%activity_logs}}', 'user_id');
        $this->createIndex('idx_activity_logs_entity', '{{%activity_logs}}', ['entity_type', 'entity_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_activity_logs_user', '{{%activity_logs}}');
        $this->dropTable('{{%activity_logs}}');
    }
}
