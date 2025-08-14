<?php

use yii\db\Migration;

class m250813_083523_alter_user_table_add_role_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'role_id', $this->integer()->after('email'));
        $this->addColumn('{{%user}}', 'deleted_at', $this->dateTime()->defaultValue(null)->after('updated_at'));


        // Indexes for performance
        $this->createIndex('idx_user_email', '{{%user}}', 'email', true); // unique index for login
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'role_id');
        $this->dropColumn('{{%user}}', 'deleted_at');
        echo "m250813_083523_alter_user_table_add_role_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250813_083523_alter_user_table_add_role_id cannot be reverted.\n";

        return false;
    }
    */
}
