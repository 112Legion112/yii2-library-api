<?php
return [
    [
        'user_id' => 1,
        'token' => 'token-correct-user-erau-1',
        'expired_at' => time() + 3600,
    ],
    [
        'user_id' => 2,
        'token' => 'token-correct-user-john-2',
        'expired_at' => time() + 3600,
    ],
    [
        'user_id' => 1,
        'token' => 'token-expired',
        'expired_at' => time() - 3600,
    ],
];
