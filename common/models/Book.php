<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $name
 *
 * @property BookLog[] $bookLogs
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookLogs()
    {
        return $this->hasMany(BookLog::className(), ['book_id' => 'id']);
    }

    public function isTaken(){
        return BookLog::findOne(['book_id' => $this->id, 'date_returned'=>null]) ? true : false;
    }

    public function getIdOwner(){
        $bookLog = BookLog::findOne(['book_id' => $this->id, 'date_returned'=>null]);
        return $bookLog->user_id;
    }
}
