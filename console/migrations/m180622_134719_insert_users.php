<?php

use yii\db\Migration;

/**
 * Class m180622_134719_insert_users
 */
class m180622_134719_insert_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    const DATA_USERS = [
        [
            'id' => 1,
            'username' => 'erau',
            'auth_key' => 'tUu1qHcde0diwUol3xeI-18MuHkkprQI',
            // password_0
            'password_hash' => '$2y$13$nJ1WDlBaGcbCdbNC5.5l4.sgy.OMEKCqtDQOdQ2OWpgiKRWYyzzne',
            'password_reset_token' => null,
            'created_at' => '1392559490',
            'updated_at' => '1392559490',
            'email' => 'sfriesen@jenkins.info',
        ],
        [
            'id' => 2,
            'username' => 'john',
            'auth_key' => 'tUu1qHcde0diwUol3xeI-18MuHkkprQI',
            'password_hash' => '$2y$13$nJ1WDlBaGcbCdbNC5.5l4.sgy.OMEKCqtDQOdQ2OWpgiKRWYyzznsd',
            'password_reset_token' => null,
            'created_at' => '1392559490',
            'updated_at' => '1392559490',
            'email' => 'john@jenkins.info',
        ]
    ];

    public function safeUp()
    {
        foreach(self::DATA_USERS as $dataUser){
            $this->insert('{{%user}}', $dataUser);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach(self::DATA_USERS as $dataUser){
            $this->delete('{{%user}}', $dataUser);
        }
    }
}
