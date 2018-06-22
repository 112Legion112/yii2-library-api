<?php

use yii\db\Migration;

/**
 * Handles the creation of table `book_log`.
 */
class m180621_113356_create_book_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%book_log}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'book_id' => $this->integer()->notNull(),
            'date_taken' => $this->integer()->notNull(),
            'date_returned' => $this->integer(),
        ],$tableOptions);

        $this->addForeignKey('fk-book_log-user', '{{%book_log}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-book_log-book', '{{%book_log}}', 'book_id', '{{%book}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book_log}}');
    }
}
