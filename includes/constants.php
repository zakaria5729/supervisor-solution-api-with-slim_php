<?php

    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'our_supervisor');

    define('USER_CREATED', 101);
    define('USER_EXISTS', 102);
    define('USER_GROUP_EXISTS', 103);
    define('USER_FAILURE', 104);

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
    define('VERIFICATION_CODE_WRONG', 603);

    define('TOKEN_DO_NOT_MATCH', 701);

    define('ALREADY_REGISTERED', 801);
    define('REGISTRATION_SUCCESSFUL', 802);
    define('STUDENT_LIST_INSERTION_FAILED', 803);
    define('SUPERVISOR_LIST_INSERTION_FAILED', 804);
    define('TITLE_DEFENSE_ROW_INSERTION_FAILED', 805);

    define('SUPER_ADDED_FAILED', 901);
    define('SUPER_ADDED_SUCCESSFUL', 902);

    define('REQUEST_ACCEPTED', 1001);
    define('REQUEST_ACCEPTED_FAILED', 1002);
    define('REQUEST_DECLINED_SUCCESSFULLY', 1003);
    define('REQUEST_DECLINED_FAILED', 1004);

?>