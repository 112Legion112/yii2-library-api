<?php
namespace api\tests\api;



use api\tests\ApiTester;
use common\fixtures\BookFixture;
use common\fixtures\BookLogFixture;
use common\fixtures\TokenFixture;
use common\fixtures\UserFixture;

class LibraryCest {
    const NOT_EXISTING_BOOK_ID = 99999999;
    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
            'token' => [
                'class' => TokenFixture::className(),
                'dataFile' => codecept_data_dir() . 'token.php'
            ],
            'book' => [
                'class' => BookFixture::className(),
                'dataFile' => codecept_data_dir() . 'book.php'
            ],
            'book-log' => [
                'class' => BookLogFixture::className(),
                'dataFile' => codecept_data_dir() . 'bookLog.php'
            ]
        ]);
    }

    public function takeBookUnauthorized(ApiTester $I)
    {
        $I->sendPOST('/library/take',[
            'book_id' => 1,
        ]);
        $I->seeResponseCodeIs(401);
    }

    public function takeBook(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-user-erau-1');
        $I->sendPOST('/library/take',[
            'book_id' => 1,
        ]);
        $I->seeResponseCodeIs(200);
    }

    public function takeNotExistingBook(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-user-erau-1');
        $I->sendPOST('/library/take',[
            'book_id' => self::NOT_EXISTING_BOOK_ID,
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'message' => 'Book ID is invalid.'
        ]);
    }

    public function takeBookThatIAlreadyHave(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-user-erau-1');
        $I->sendPOST('/library/take',[
            'book_id' => 2,
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'message' => 'Вы ужe взяли эту книгу!'
        ]);
    }

    public function takeTakenBookThatIDonNotHave(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-user-erau-1');
        $I->sendPOST('/library/take',[
            'book_id' => 3,
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'message' => 'Книга взята кем-то!'
        ]);
    }



    public function returnBookUnauthorized(ApiTester $I)
    {
        $I->sendPOST('/library/return',[
            'book_id' => 1,
        ]);
        $I->seeResponseCodeIs(401);
    }

    public function returnNotExistingBook(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-user-erau-1');
        $I->sendPOST('/library/return',[
            'book_id' => self::NOT_EXISTING_BOOK_ID,
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'message' => 'Book ID is invalid.'
        ]);
    }


    public function returnBookThatITook(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-user-erau-1');
        $I->sendPOST('/library/return',[
            'book_id' => 2,
        ]);
        $I->seeResponseCodeIs(200);
    }

    public function returnNotTakenBook(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-user-erau-1');
        $I->sendPOST('/library/return',[
            'book_id' => 1,
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'message' => 'Книга не взята!'
        ]);
    }

    public function returnTakenBookThatIDidNotTake(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-user-erau-1');
        $I->sendPOST('/library/return',[
            'book_id' => 3,
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'message' => 'У Вас нету этой книги!'
        ]);
    }

}