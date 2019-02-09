<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../includes/DbOperations.php';
require '../includes/mailer.php';

$app = new \Slim\App;

// $app = new \Slim\App([
//     'settings'=>[
//         'displayErrorDetails'=>true
//     ]
// ]);

/**
 * endpoint: create_account
 * parameters: email, password, verification_code, status
 * method: POST
 */


// if (send_verification_code_to_email($email, $verification_code)) {
//     $message['error'] = false;
//     $message['message'] = 'Account create successfully. Check your email';

//     $response->write(json_encode($message));
//     $response_code = 201;
//  } else {
//     $message['error'] = false;
//     $message['message'] = 'Account not created, email send problem';

//     $response->write(json_encode($message));
//     $response_code = 422;
//  }

//  return $response
//     ->withHeader('Content-type', 'application/json')
//     ->withStatus($response_code); //http status code

 $app->post('/create_account', function(Request $request, Response $response) {

     //if(!haveEmptyParameters(array('email', 'password', 'verification_code', 'status'), $response)) {
     
        if(!haveEmptyParameters(array('email', 'password'), $response)) {
         $request_data = $request->getParsedBody();

         $email = $request_data['email'];
         $password = $request_data['password'];
         $verification_code = random_int(100000, 999999); //this method gives 6 digit randomly
         $status = 0;

         $hash_password = password_hash($password, PASSWORD_DEFAULT);

         $db = new DbOperations();
         $result = $db->createAccount($email, $hash_password, $verification_code, $status);

         if($result == USER_CREATED) {
             $message = array();
             $message['error'] = false;
             $message['message'] = 'Account create successfully';

             $response->write(json_encode($message));
             return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(201); //http status code

         } else if($result == USER_FAILURE) {
            $message = array();
             $message['error'] = true;
             $message['message'] = 'Some error occured. Try again';

             $response->write(json_encode($message));
             return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(422);

         } else if($result == USER_EXISTS) {
            $message = array();
             $message['error'] = true;
             $message['message'] = 'Account already exists';

             $response->write(json_encode($message));
             return $response
                        ->withHeader('Content-type', 'application/json')
                        ->withStatus(422);
         }
     }
 });

 function haveEmptyParameters($required_params, $response) {
     $error = false;
     $error_params = '';
     $request_params = $_REQUEST;

     foreach($request_params as $param) {
         if(!isset($request_params[$param]) || strlen($request_params[$param])<=0) {
             $error = true;
             $error_params .= $param . ', ';
         }
     }

     if($error) {
         $error_detail = array();
         $error_detail['error'] = true;
         $error_detail['message'] = 'Required parameters ' . substr($error_params, 0, -2);

         $response->write(json_encode($error_detail));
     }

     return $error;
 }

$app->run();