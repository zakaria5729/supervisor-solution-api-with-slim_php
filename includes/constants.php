<?php

    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'our_supervisor');

    define('USER_CREATED', 101);
    define('USER_EXISTS', 102);
    define('USER_FAILURE', 103);

    define('USER_AUTHENTICATED', 201);
    define('USER_NOT_FOUND', 202);
    define('USER_PASSWORD_DO_NOT_MATCH', 203);

    define('PASSWORD_CHANGED', 301);
    define('PASSWORD_DO_NOT_MATCH', 302);
    define('PASSWORD_NOT_CHANGED', 303);
    
    define('PASSWORD_RESET', 401);
    define('PASSWORD_NOT_RESET', 402);

    define('STATUS_UPDATED', 501);
    define('STATUS_NOT_UPDATED', 502);
    define('STATUS_EMAIL_AND_VERIFICATION_CODE_NOT_MATCH', 503);
    define('STATUS_ALREADY_UPDATED', 504);

    define('VERIFICATION_CODE_UPDATED', 601);
    define('VERIFICATION_CODE_UPDATE_FAILED', 602);
    define('VERIFICATION_CODE_SEND_FAILED', 603);

?>