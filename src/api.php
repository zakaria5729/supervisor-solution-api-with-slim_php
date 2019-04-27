<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../includes/mailer.php';
require '../includes/DbOperations.php';

$app = new \Slim\App([
    'settings'=>[
        'displayErrorDetails'=>true
    ]
]);

$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
    "secure" => false,
    "users" => [
        "diu_supervisor_solution" => 'admin@diu_supervisor_solution'
    ],
    "error" => function ($response, $arguments) {
        $data["error"] = true;
        $data["message"] = $arguments["message"];
        return $response
            ->withHeader("Content-Type", "application/json")
            ->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
]));

 //Create user
 $app->post('/create_user', function(Request $request, Response $response) {     
        if(!haveEmptyParameters($request, $response, array('name', 'email', 'password'))) {
         $request_data = $request->getParams();

         $name = $request_data['name'];
         $email = $request_data['email'];
         $password = $request_data['password'];
         $user_role = "Student";
         $verification_code = random_int(100000, 999999); //generate 6 digit randomly

         //Removing HTML from a string and special characters
		 //$name = htmlspecialchars(strip_tags($name));
		 //$email = htmlspecialchars(strip_tags($email));
		 //$password = htmlspecialchars(strip_tags($password));
		 //$fcm_token = htmlspecialchars(strip_tags($fcm_token));
		 //$user_role = htmlspecialchars(strip_tags($user_role));

         $hash_password = password_hash($password, PASSWORD_DEFAULT);
         $message = array();

         $db = new DbOperations();
         $result = $db->createAccount($name, $email, $hash_password, $user_role, $verification_code);   

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

         } else if($result == USER_GROUP_EXISTS) {
            $message['error'] = true;
            $message['message'] = 'Your group leder already completed yours registration. Contact with him';
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
$app->post('/login_or_signin', function(Request $request, Response $response) {
    if(!haveEmptyParameters($request, $response, array('name', 'email', 'password', 'token', 'user_role', 'login_type'))) {
       $request_data = $request->getParams();
       
       $name = $request_data['name'];
       $email = $request_data['email'];
       $password = $request_data['password'];
       $token = $request_data['token'];
       $user_role = $request_data['user_role'];
       $login_type = $request_data['login_type'];
       
       $db = new DbOperations();
       $response_data = array();

       if($login_type == "login_email") {
           $result = $db->userLoginWtihPassword($email, $password, $user_role);
       } else if($login_type == "google_sign_in") {
           $result = $db->userSignInWithGoogle($name, $email, $token, $user_role);
       }

       if($result == USER_AUTHENTICATED) {
           $user = $db->getUserByEmial($email);

           $response_data['error'] = false;
           $response_data['message'] = 'Login successful';
           $response_data['user'] = $user;

       } else if($result == STATUS_NOT_UPDATED) {
           $response_data['error'] = true;
           $response_data['message'] = 'Please check your inbox and verify your email first';

       } else if($result == USER_NOT_FOUND) {
           $response_data['error'] = true;
           $response_data['message'] = 'User not exists';

       } else if($result == PASSWORD_DO_NOT_MATCH) {
           $response_data['error'] = true;
           $response_data['message'] = 'Invalid email or password';

       } else if($result == USER_FAILURE) {
           $response_data['error'] = true;
           $response_data['message'] = 'User sign in failed. Try again later';

       } else if($result == TOKEN_DO_NOT_MATCH) {
           $response_data['error'] = true;
           $response_data['message'] = 'Invalid email or token';

       } else if($result == USER_GROUP_EXISTS) {
           $message['error'] = true;
           $message['message'] = 'Your group leder already completed yours registration. Contact with him';
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

 $app->post('/title_defense_registration',function(Request $request, Response $response) {
    if(!haveEmptyParameters($request, $response, array('project_internship', 'project_internship_type', 'project_internship_title', 'area_of_interest', 'day_evening'))) {
        $request_data = $request->getParams();

        $project_internship = $request_data['project_internship'];
        $project_internship_type = $request_data['project_internship_type'];
        $project_internship_title = $request_data['project_internship_title'];
        $area_of_interest = $request_data['area_of_interest'];
        $day_evening = $request_data['day_evening'];

        $student_list = $request_data['student_list'];
        $supervisor_list = $request_data['supervisor_list'];

        //Removing HTML from a string and special characters
		 $project_internship = htmlspecialchars(strip_tags($project_internship));
		 $project_internship_type = htmlspecialchars(strip_tags($project_internship_type));
		 $project_internship_title = htmlspecialchars(strip_tags($project_internship_title));
		 $area_of_interest = htmlspecialchars(strip_tags($area_of_interest));
         $day_evening = htmlspecialchars(strip_tags($day_evening));

        if(!haveEmptyParametersWithArray($request, $response, array('student_list', 'supervisor_list'))) {
            $db = new DbOperations();
            $message = array();

            $result = $db->titleDefenseRegistration($project_internship, $project_internship_type, $project_internship_title, $area_of_interest, $day_evening, $student_list, $supervisor_list);

            if($result == ALREADY_REGISTERED) {
                $message['error'] = false;
                $message['message'] = 'Already registered';
                $response_code = 200;

            } else if($result == REGISTRATION_SUCCESSFUL) {
                $message['error'] = false;
                $message['message'] = 'Successfully registered';
                $response_code = 201;

                $result = $db->setSuper($student_list, $supervisor_list);

                if($result == SUPER_ADDED_SUCCESSFUL) {


                } else if($result == SUPER_ADDED_FAILED) {

                }

            }  else if($result == STUDENT_LIST_INSERTION_FAILED) {
                $message['error'] = false;
                $message['message'] = 'Student list insertion failed. Try again';
                $response_code = 422;
                
            }  else if($result == SUPERVISOR_LIST_INSERTION_FAILED) {
                $message['error'] = false;
                $message['message'] = 'Supervisor list insertion failed. Try again';
                $response_code = 422;
                
            }  else if($result == TITLE_DEFENSE_ROW_INSERTION_FAILED) {
                $message['error'] = false;
                $message['message'] = 'Title defense row insertion failed. Try again';
                $response_code = 422;
            }
            
            $response->write(json_encode($message));

        } else {
            $response_code = 422;
        }
    } else {
        $response_code = 422;
    }

    return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus($response_code);
});

$app->post('/accepted_group_list', function(Request $request, Response $response) {
    if(!haveEmptyParameters($request, $response, array('supervisor_email'))) {
        $request_data = $request->getParams();
        $supervisor_email = $request_data['supervisor_email'];

        //Removing HTML from a string and special characters
		$supervisor_email = htmlspecialchars(strip_tags($supervisor_email));

        $db = new DbOperations();
        $accepted_group_list = $db->getAcceptedGroupList($supervisor_email);
        $response_data = array();

        if($accepted_group_list != null) {
            $response_data['error'] = false;
            $response_data['accepted_group_list'] = $accepted_group_list;
        } else {
            $response_data['error'] = true;
            $response_data['accepted_group_list'] = array(array());
        }

        $response_code = 200;
        $response->write(json_encode($response_data));

    } else {
        $response_code = 422;
    }

    return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus($response_code);
});

$app->post('/requested_group_list', function(Request $request, Response $response) {
    if(!haveEmptyParameters($request, $response, array('supervisor_email'))) {
        $request_data = $request->getParams();
        $supervisor_email = $request_data['supervisor_email'];

        //Removing HTML from a string and special characters
		$supervisor_email = htmlspecialchars(strip_tags($supervisor_email));

        $db = new DbOperations();
        $requested_group_list = $db->getRequestedGroupList($supervisor_email);
        $response_data = array();

        if($requested_group_list != null) {
            $response_data['error'] = false;
            $response_data['requested_group_list'] = $requested_group_list;
        } else {
            $response_data['error'] = true;
            $response_data['requested_group_list'] = array(array());
        }

        $response_code = 200;
        $response->write(json_encode($response_data));

    } else {
        $response_code = 422;
    }

    return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus($response_code);
});

$app->post('/group_accept_or_decline', function(Request $request, Response $response) {
    if(!haveEmptyParameters($request, $response, array('supervisor_email', 'group_email', 'accept_or_decline'))) {
        $request_data = $request->getParams();
        $supervisor_email = $request_data['supervisor_email'];
        $group_email = $request_data['group_email'];
        $accept_or_decline = $request_data['accept_or_decline'];

        //Removing HTML from a string and special characters
        $supervisor_email = htmlspecialchars(strip_tags($supervisor_email));
        $group_email = htmlspecialchars(strip_tags($group_email));
        $accept_or_decline = htmlspecialchars(strip_tags($accept_or_decline));

        $db = new DbOperations();
        $result = $db->manageRequestedGroupList($supervisor_email, $group_email, $accept_or_decline);

        $response_data = array();
        if($result == REQUEST_ACCEPTED) {
            $response_data['error'] = false;
            $response_data['message'] = 'Request accepted';

        } else if($result == REQUEST_ACCEPTED_FAILED) {
            $response_data['error'] = true;
            $response_data['message'] = 'Request accepted failed';

        } else if($result == REQUEST_DECLINED_SUCCESSFULLY) {
            $response_data['error'] = false;
            $response_data['message'] = 'Request declined successfully';

        } if($result == REQUEST_DECLINED_FAILED) {
            $response_data['error'] = true;
            $response_data['message'] = 'Request declined failed';
        }

        $response_code = 200;
        $response->write(json_encode($response_data));

    } else {
        $response_code = 422;
    }

    return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus($response_code);
});

$app->post('/group_list_status', function(Request $request, Response $response) {
    if(!haveEmptyParameters($request, $response, array('group_email'))) {
        $request_data = $request->getParams();
        $group_email = $request_data['group_email'];

        //Removing HTML from a string and special characters
        $group_email = htmlspecialchars(strip_tags($group_email));

        $db = new DbOperations();
        $response_data = array();

        $group_list_status = $db->studentGroupListStatus($group_email);

        if($group_list_status != null) {
            $response_data['error'] = false;
            $response_data['group_list_status'] = $group_list_status;
        } else {
            $response_data['error'] = true;
            $response_data['group_list_status'] = array();
        }

        $response_code = 200;
        $response->write(json_encode($response_data));

    } else {
        $response_code = 422;
    }

    return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus($response_code);
});

 //Email verification
 $app->post('/verification', function(Request $request, Response $response) {
     if(!haveEmptyParameters($request, $response, array('email', 'verification_code'))) {
         $request_data = $request->getParams();

         $email = $request_data['email'];
         $verification_code = $request_data['verification_code'];
         
         //Removing HTML from a string and special characters
		 $email = htmlspecialchars(strip_tags($email));
		 $verification_code = htmlspecialchars(strip_tags($verification_code));

         $db = new DbOperations();
         $result = $db->emailVerification($email, $verification_code);
         $response_data = array();

         if($result == STATUS_UPDATED) {
             $response_data['error'] = false;
             $response_data['message'] = 'Successfully verified and status updated';

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

        //Removing HTML from a string and special characters
		$email = htmlspecialchars(strip_tags($email));

        $message = array();
        $db = new DbOperations();        
        $result = $db->forgotPassword($email, $verification_code);

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
$app->put('/update_user', function(Request $request, Response $response) {
    if(!haveEmptyParameters($request, $response, array('name', 'email'))) {
        $request_data = $request->getParams();

        $name = $request_data['name'];
        $email = $request_data['email'];

        //Removing HTML from a string and special characters
		$name = htmlspecialchars(strip_tags($name));
		$email = htmlspecialchars(strip_tags($email));

        $db = new DbOperations();
        $response_data = array();

        if($db->updateUser($name, $email)) {
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
$app->put('/change_password', function(Request $request, Response $response) {
    if(!haveEmptyParameters($request, $response, array('email', 'current_password', 'new_password'))) {
        $request_data = $request->getParams();

        $email = $request_data['email'];
        $current_password = $request_data['current_password'];
        $new_password = $request_data['new_password'];

        //Removing HTML from a string and special characters
		$email = htmlspecialchars(strip_tags($email));
		$current_password = htmlspecialchars(strip_tags($current_password));
		$new_password = htmlspecialchars(strip_tags($new_password));

        $db = new DbOperations();
        $result = $db->changePassword($email, $current_password, $new_password);
        $response_data = array();

        if($result == PASSWORD_CHANGED) {
            $response_data['error'] = false;
            $response_data['message'] = 'Password has been changed';

        } else if($result == PASSWORD_NOT_CHANGED) {
            $response_data['error'] = true;
            $response_data['message'] = 'Password not changed. Try again later';

        } else if($result == PASSWORD_DO_NOT_MATCH) {
            $response_data['error'] = true;
            $response_data['message'] = 'Invalid current password';
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
 $app->put('/reset_password', function(Request $request, Response $response) {
    if(!haveEmptyParameters($request, $response, array('email', 'verification_code', 'new_password'))) {
        $request_data = $request->getParams();

        $email = $request_data['email'];
        $verification_code = $request_data['verification_code'];
        $new_password = $request_data['new_password'];
        $password_status = 1;

        //Removing HTML from a string and special characters
		$email = htmlspecialchars(strip_tags($email));
		$verification_code = htmlspecialchars(strip_tags($verification_code));
		$new_password = htmlspecialchars(strip_tags($new_password));

        $db = new DbOperations();
        $result = $db->resetPassword($email, $verification_code, $new_password, $password_status);
        $response_data = array();

        if($result == PASSWORD_RESET) {
            $response_data['error'] = false;
            $response_data['message'] = 'Password has been reset';

        } else if($result == PASSWORD_NOT_RESET) {
            $response_data['error'] = true;
            $response_data['message'] = 'Password not reset. Try again later';
        } else if($result == VERIFICATION_CODE_WRONG) {
            $response_data['error'] = true;
            $response_data['message'] = 'Wrong verification code. Try again';
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

    //Removing HTML from a string and special characters
	$id = htmlspecialchars(strip_tags($id));

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
$app->get('/users', function(Request $request, Response $response) {
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
$app->get('/topic_list', function(Request $request, Response $response) {
    $db = new DbOperations();
    $topics = $db->getTopicList();
    $response_data = array();

    if($topics != null) {
        $response_data['error'] = false;
        $response_data['topics'] = $topics;
    } else {
        $response_data['error'] = true;
        $response_data['topics'] = 'No data found';
    }

    $response->write(json_encode($response_data, JSON_PRETTY_PRINT));
    return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);
});

 //Get all supervisors
$app->get('/supervisor_list', function(Request $request, Response $response) {
    $db = new DbOperations();
    $supervisors = $db->getSupervisorList();
    $response_data = array();

    if($supervisors != null) {
        $response_data['error'] = false;
        $response_data['supervisors'] = $supervisors;
    } else {
        $response_data['error'] = true;
        $response_data['supervisors'] = 'No data found';
    }

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

 function haveEmptyParametersWithArray($request, $response, $required_params) {
    $error = false;
    $error_params = '';
    $request_params = $request->getParams();

    foreach($required_params as $param) {
        if(empty($request_params[$param])) {
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