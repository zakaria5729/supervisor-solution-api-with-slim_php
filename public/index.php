<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../includes/mailer.php';
require '../includes/DbOperations.php';

//$app = new \Slim\App();

$app = new \Slim\App([
    'settings'=>[
        'displayErrorDetails'=>true
    ]
]);

/**
 * endpoint: create_account
 * parameters: email, password, verification_code, status
 * method: POST
 */

 //Create user
 $app->post('/create', function(Request $request, Response $response) {     
        if(!haveEmptyParameters($request, $response, array('email', 'password'))) {
         $request_data = $request->getParams();

         $email = $request_data['email'];
         $password = $request_data['password'];
         $verification_code = random_int(100000, 999999); //generate 6 digit randomly
         $status = 0;

         $hash_password = password_hash($password, PASSWORD_DEFAULT);
         $message = array();

         $db = new DbOperations();
         $result = $db->createAccount($email, $hash_password, $verification_code, $status);   

         if($result == USER_CREATED) {
            $message['error'] = false;
            $message['message'] = 'Account create successfully. Check your email for verification';
            $response_code = 201;

         } else if($result == USER_FAILURE) {
             $message['error'] = true;
             $message['message'] = 'Some error occured. Try again';
             $response_code = 422;

         } else if($result == VERIFICATION_CODE_SEND_FAILED) {
            $message['error'] = true;
            $message['message'] = 'Account create successfully. But email verification code sending failed. Please, try forgot password option';
            $response_code = 422;

        } else if($result == USER_EXISTS) {
             $message['error'] = true;
             $message['message'] = 'Account already exists.';
             $response_code = 200;
         }

         $response->write(json_encode($message));
     } else {
        $response_code = 422;
    }

    return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus($response_code);
 });

 //User login
 $app->post('/login', function(Request $request, Response $response){
     if(!haveEmptyParameters($request, $response, array('email', 'password'))) {
        $request_data = $request->getParams();
        
        $email = $request_data['email'];
        $password = $request_data['password'];
        
        $db = new DbOperations();
        $result = $db->userLogin($email, $password);
        $response_data = array();

        if($result == USER_AUTHENTICATED) {
            $user = $db->getUserByEmial($email);

            $response_data['error'] = false;
            $response_data['message'] = 'Login successful';
            $response_data['user'] = $user;

        } else if($result == STATUS_NOT_UPDATED) {
            $response_data['error'] = true;
            $response_data['message'] = 'Please, check your inbox and verify your email first';

        } else if($result == USER_NOT_FOUND) {
            $response_data['error'] = true;
            $response_data['message'] = 'User not exists';

        } else if($result == PASSWORD_DO_NOT_MATCH) {
            $response_data['error'] = true;
            $response_data['message'] = 'Invalid email or password';
        }

        $response->write(json_encode($response_data));
        $response_code = 200;
     } else {
        $response_code = 422;
     }

     return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus($response_code);
 });

 //Email verification
 $app->post('/verification', function(Request $request, Response $response){
     if(!haveEmptyParameters($request, $response, array('email', 'verification_code'))) {
         $request_data = $request->getParams();

         $email = $request_data['email'];
         $verification_code = $request_data['verification_code'];

         $db = new DbOperations();
         $result = $db->emailVerification($email, $verification_code);
         $response_data = array();

         if($result == STATUS_UPDATED) {
             $response_data['error'] = false;
             $response_data['message'] = 'Status updated';

         } else if($result == STATUS_ALREADY_UPDATED) {
            $response_data['error'] = false;
            $response_data['message'] = 'Status already updated';

         } else if($result == STATUS_NOT_UPDATED) {
            $response_data['error'] = true;
            $response_data['message'] = 'Status updated failed. Try again later';

         } else if($result == STATUS_EMAIL_AND_VERIFICATION_CODE_NOT_MATCH) {
            $response_data['error'] = true;
            $response_data['message'] = 'Email or verification code not matched';

         }

        $response->write(json_encode($response_data));
        $response_code = 200;
     } else {
        $response_code = 422;
     }

     return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus($response_code);
 });

 //Forgot password
 $app->post('/forgot_password', function(Request $request, Response $response) {     
    if(!haveEmptyParameters($request, $response, array('email'))) {
        $request_data = $request->getParams();

        $email = $request_data['email'];
        $verification_code = random_int(100000, 999999);

        $message = array();
        $db = new DbOperations();        
        $result = $db->forgot_password($email, $verification_code);

        if($result == VERIFICATION_CODE_UPDATED) {
            $message['error'] = false;
            $message['message'] = 'Verification code sent. Please, check your email for verification';
            $response_code = 200;

        } else if($result == VERIFICATION_CODE_UPDATE_FAILED) {
            $message['error'] = true;
            $message['message'] = 'Email verification code update failed. Please, try again later';
            $response_code = 422;

        } else if($result == VERIFICATION_CODE_SEND_FAILED) {
            $message['error'] = true;
            $message['message'] = 'Email verification code sending failed. Please, try again later';
            $response_code = 422;

        } else if($result == USER_NOT_FOUND) {
            $message['error'] = true;
            $message['message'] = 'User not found in this email';
            $response_code = 200;
        }

        $response->write(json_encode($message));
    } else {
        $response_code = 422;
    }

    return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus($response_code);
});

 //Update user data
$app->put('/update_user', function(Request $request, Response $response){
    if(!haveEmptyParameters($request, $response, array('id', 'email'))) {
        $request_data = $request->getParams();
        $id = $request_data['id'];
        $email = $request_data['email'];

        $db = new DbOperations();
        $response_data = array();

        if($db->updateUser($id, $email)) {
            $response_data['error'] = false;
            $response_data['message'] = 'User updated successfully';

            $user = $db->getUserByEmial($email);
            $response_data['user'] = $user;

        } else {
            $response_data['error'] = true;
            $response_data['message'] = 'User not updated. Try again later';
        }

        $response->write(json_encode($response_data));
        $response_code = 200;
    }  else {
        $response_code = 422;
    }

    return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus($response_code);
});

 //Update password
$app->put('/update_password', function(Request $request, Response $response){
    if(!haveEmptyParameters($request, $response, array('email', 'current_password', 'new_password'))) {
        $request_data = $request->getParams();
        $email = $request_data['email'];
        $current_password = $request_data['current_password'];
        $new_password = $request_data['new_password'];

        $db = new DbOperations();
        $result = $db->updatePassword($email, $current_password, $new_password);
        $response_data = array();

        if($result == PASSWORD_CHANGED) {
            $response_data['error'] = false;
            $response_data['message'] = 'Password has been changed';

        } else if($result == PASSWORD_NOT_CHANGED) {
            $response_data['error'] = true;
            $response_data['message'] = 'Password not changed. Try again later';

        } else if($result == PASSWORD_DO_NOT_MATCH) {
            $response_data['error'] = true;
            $response_data['message'] = 'Your given password is invalid';
        }

        $response->write(json_encode($response_data));
        $response_code = 200;
    } else {
        $response_code = 422;
    }

    return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus($response_code);
});

 //Reset password
 $app->put('/reset_password', function(Request $request, Response $response){
    if(!haveEmptyParameters($request, $response, array('email', 'new_password'))) {
        $request_data = $request->getParams();
        $email = $request_data['email'];
        $new_password = $request_data['new_password'];

        $db = new DbOperations();
        $result = $db->resetPassword($email, $new_password);
        $response_data = array();

        if($result == PASSWORD_RESET) {
            $response_data['error'] = false;
            $response_data['message'] = 'Password has been reset';

        } else if($result == PASSWORD_NOT_RESET) {
            $response_data['error'] = true;
            $response_data['message'] = 'Password not reset. Try again later';
        }

        $response->write(json_encode($response_data));
        $response_code = 200;
    } else {
        $response_code = 422;
    }

    return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus($response_code);
 });

 //Delete user
$app->delete('/delete/{id}', function(Request $request, Response $response, array $args) {
    $db = new DbOperations();
    
    $id = $args['id'];
    $response_data = array();

    if($db->deleteUser($id)) {
        $response_data['error'] = false;
        $response_data['message'] = 'Student has been deleted';
    } else {
        $response_data['error'] = true;
        $response_data['message'] = 'Student not delete. Try again later';
    }

    $response->write(json_encode($response_data));
    return $response
                ->withHeader('Content-type', 'application/josn')
                ->withStatus(200);
});

 //Get all users data
$app->get('/students', function(Request $request, Response $response) {
    $db = new DbOperations();
    $users = $db->getAllUser();

    $response_data = array();
    $response_data['error'] = false;
    $response_data['users'] = $users;

    $response->write(json_encode($response_data, JSON_PRETTY_PRINT));
    return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);
});

 //Get all topics
$app->get('/topics', function(Request $request, Response $response) {
    $db = new DbOperations();
    $topics = $db->getTopics();

    $response_data = array();
    $response_data['error'] = false;
    $response_data['topics'] = $topics;

    $response->write(json_encode($response_data, JSON_PRETTY_PRINT));
    return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);
});

 //Get all supervisors
$app->get('/supervisors', function(Request $request, Response $response) {
    $db = new DbOperations();
    $topics = $db->getSupervisors();

    $response_data = array();
    $response_data['error'] = false;
    $response_data['topics'] = $topics;

    $response->write(json_encode($response_data, JSON_PRETTY_PRINT));
    return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);
});

function haveEmptyParameters($request, $response, $required_params) {
     $error = false;
     $error_params = '';
     $request_params = $request->getParams();

     foreach($required_params as $param) {
         if(!isset($request_params[$param]) || strlen($request_params[$param])<=0) {
             $error = true;
             $error_params .= $param . ', ';
         }
     }

     if($error) {
         $error_detail = array();
         $error_detail['error'] = true;
         $error_detail['message'] = 'Required parameters: ' . substr($error_params, 0, -2);

         $response->write(json_encode($error_detail));
     }

     return $error;
 }

$app->run();

?>