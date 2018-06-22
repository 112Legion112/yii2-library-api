<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "book_log".
 *
 * @property int $id
 * @property int $user_id
 * @property int $book_id
 * @property int $date_taken
 * @property int $date_returned
 *
 * @property Book $book
 * @property User $user
 */
class BookLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_log';
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_taken'],
//                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_returned'],
                ]
            ],

        ];
    }

    const SCENARIO_TAKE_BOOK = 'scenario_take_book';
    const SCENARIO_RETURN_BOOK = 'scenario_return_book';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id'], 'required'],
            [['user_id', 'book_id', 'date_taken', 'date_returned'], 'integer'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['book_id', 'validateTakeBook', 'on' => self::SCENARIO_TAKE_BOOK],
            ['book_id', 'validateReturnBook', 'on' => self::SCENARIO_RETURN_BOOK],
        ];
    }

    public function validateTakeBook($attribute){
        if($this->book->isTaken()){
            if($this->book->getIdOwner() == $this->user_id){
                $this->addError($attribute, 'Вы ужe взяли эту книгу!');
            }else{
                $this->addError($attribute, 'Книга взята кем-то!');
            }
        }
    }

    public function validateReturnBook($attribute){
        if(!$this->book->isTaken()){
            $this->addError($attribute, 'Книга не взята!');
        }elseif($this->book->getIdOwner() != $this->user_id){
            $this->addError($attribute, 'У Вас нету этой книги!');
        }

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'book_id' => Yii::t('app', 'Book ID'),
            'date_taken' => Yii::t('app', 'Date Taken'),
            'date_returned' => Yii::t('app', 'Date Returned'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function takeBook($book_id, $user_id){
        $bookLog = new BookLog(['scenario' => self::SCENARIO_TAKE_BOOK]);

        $bookLog->book_id = $book_id;
        $bookLog->user_id = $user_id;
        $bookLog->save();
        return $bookLog;
    }


    public static function returnBook($book_id, $user_id){
        $bookLog = self::find()->where(['book_id' => $book_id, 'user_id'=>$user_id , 'date_returned' => null])->one();
        if($bookLog){
            $bookLog->date_returned = time();
            $bookLog->save();
        }else{
            $bookLog = new BookLog(['scenario' => self::SCENARIO_RETURN_BOOK]);
            $bookLog->book_id = $book_id;
            $bookLog->user_id = $user_id;
            $bookLog->validate();
        }
        return $bookLog;
    }
}
