<?php

use yii\db\Migration;

/**
 * Class m191010_144041_init_role
 */
class m191010_144041_init_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'role', $this->string(64));
        $this->update('{{%user}}', ['role' => 'user']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'role');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191010_144041_add_column_role_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
