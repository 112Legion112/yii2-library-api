<?php

use yii\db\Migration;

/**
 * Class m180622_133444_insert_books
 */
class m180622_133444_insert_books extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        for($i = 1; $i<=100; $i++){
            $this->insert('{{%book}}', [
                'id' => $i,
                'name' => 'Имя книги №' . $i,
            ]);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        for($i = 1; $i<100; $i++)
        $this->delete('{{%book}}',[
            'id' => $i,
        ]);
    }
}
