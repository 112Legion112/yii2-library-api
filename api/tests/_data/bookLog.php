<?php
return[
    [
        'id' => 1, // erau
        'user_id' => 1,
        'book_id' => 2, // Взятая книга
        'date_taken' => time() - 3600, // Книга взята час назад
        'date_returned' => null, // книга не вернута
    ],
    [
        'id' => 2,
        'user_id' => 2,//john
        'book_id' => 3, // Взятая книга
        'date_taken' => time() - 3600, // Книга взята час назад
        'date_returned' => null, // книга не вернута
    ]

];