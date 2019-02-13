<?php

class DbOperations {
    private $conn;
    private $table_students = "our_supervisor.students";
    private $table_topics = "our_supervisor.topics";
    private $table_supervisors = "our_supervisor.supervisors";

    function __construct() {
        require_once dirname(__FILE__) . '/DbConnection.php';

        $db = new DbConnection();
        $this->conn = $db->connect();
    }

    public function createAccount($name, $email, $password, $user_role, $verification_code) {
        if(!$this->isEmailExistsWtihUserRole($email, $user_role)) {
            $statement = $this->conn->prepare("INSERT INTO ".$this->table_students."(name, email, password, user_role, verification_code) VALUES(?, ?, ?, ?, ?)");
            $statement->bind_param("ssssi", $name, $email, $password, $user_role, $verification_code);

            if($statement->execute()) {
                if (send_verification_code_to_email($email, $verification_code)) {
                    return USER_CREATED;
                } else {
                    return VERIFICATION_CODE_SEND_FAILED;
                }
            } else {
                return USER_FAILURE;
            }
        } else {
            return USER_EXISTS;
        }
    }

    public function userLoginWtihPassword($email, $password,  $user_role) {
        if($this->isEmailExistsWtihUserRole($email, $user_role)) {
            $hashed_password = $this->getPasswordByEmial($email);

            if(password_verify($password, $hashed_password)) {
                if($this->isPasswordStatusUpdated($email)) {
                      return USER_AUTHENTICATED;
                } else {
                    return STATUS_NOT_UPDATED;
                }
            } else {
                return PASSWORD_DO_NOT_MATCH;
            }
        } else {
            return USER_NOT_FOUND;
        }
    }

    public function userSignInWithGoogle($name, $email, $token, $user_role) {
        if($this->isEmailExistsWtihUserRole($email, $user_role)) {

            if($this->isTokenStatusUpadated($email)) {
                $hashed_token = $this->getTokenByEmial($email);

                if(password_verify($token, $hashed_token)) {
                    return USER_AUTHENTICATED;
                } else {
                    return TOKEN_DO_NOT_MATCH;
                }

            } else {
                $hash_token = password_hash($token, PASSWORD_DEFAULT);
                $token_status = 1;
                $password_status = 1;

                $statement = $this->conn->prepare("UPDATE ".$this->table_students." SET token = ?, token_status = ?, password_status = ? WHERE email = ?");
                $statement->bind_param("siis", $hash_token, $token_status, $password_status, $email);
                
                if($statement->execute()) {
                    return USER_AUTHENTICATED;
                } else {
                    return USER_FAILURE;
                }
            }
        } else {
            $hash_token = password_hash($token, PASSWORD_DEFAULT);
            $token_status = 1;
            $password_status = 1;

            $statement = $this->conn->prepare("INSERT INTO ".$this->table_students."(name, email, user_role, password_status, token, token_status) VALUES(?, ?, ?, ?, ?, ?)");
            $statement->bind_param("sssisi", $name, $email, $user_role, $password_status, $hash_token, $token_status);

            if($statement->execute()) {
                return USER_AUTHENTICATED;
            } else {
                return USER_FAILURE;
            }
        }
    }

    private function isTokenStatusUpadated($email) {
        $statement = $this->conn->prepare("SELECT token_status FROM ".$this->table_students." WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $statement->bind_result($token_status);
        $statement->fetch();
        $statement->close();

        if($token_status == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUser($name, $email) {
        if($this->isEmailExists($email)) {
            $statement = $this->conn->prepare("UPDATE ".$this->table_students." SET name = ? WHERE email = ?");
            $statement->bind_param("ss", $name, $email);
            
            if($statement->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function updatePassword($email, $current_password, $new_password) {
        $hashed_password = $this->getPasswordByEmial($email);

        if(password_verify($current_password, $hashed_password)) {
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $statement = $this->conn->prepare("UPDATE ".$this->table_students." SET password = ? WHERE email = ?");
            $statement->bind_param("ss", $new_hashed_password, $email);

            if($statement->execute()) {
                return PASSWORD_CHANGED;
            } else {
                return PASSWORD_NOT_CHANGED;
            }
        } else {
            return PASSWORD_DO_NOT_MATCH;
        }
    }

    public function emailVerification($email, $verification_code) {
        if(!$this->isPasswordStatusUpdated($email)) {
            if($this->isEmailAndVerificationCodeMatch($email, $verification_code)) {
                if($this->updatePasswordStatus($email, 1)) {
                    return STATUS_UPDATED;
                } else {
                    return STATUS_NOT_UPDATED;
                }
            } else {
                return STATUS_EMAIL_AND_VERIFICATION_CODE_NOT_MATCH;
            }
        } else {
            return STATUS_ALREADY_UPDATED;
        }
    }

    public function forgotPassword($email, $verification_code) {
        if($this->isEmailExists($email)) {
            if(send_verification_code_to_email($email, $verification_code)) {
                $statement = $this->conn->prepare("UPDATE ".$this->table_students." SET verification_code = ? WHERE email = ?");
                $statement->bind_param("is", $verification_code, $email);

                if($statement->execute()) {
                    return VERIFICATION_CODE_UPDATED;
                } else {
                    return VERIFICATION_CODE_UPDATE_FAILED;
                }
            } else {
                return VERIFICATION_CODE_SEND_FAILED;
            }
        } else {
            return USER_NOT_FOUND;
        }
    }

    public function resetPassword($email, $verification_code, $new_password, $password_status) {
        if($this->checkVerificationCode($email, $verification_code)) {
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $statement = $this->conn->prepare("UPDATE ".$this->table_students." SET password = ?, password_status = ? WHERE email = ?");
            $statement->bind_param("sis", $new_hashed_password, $password_status, $email);

            if($statement->execute()) {
                return PASSWORD_RESET;
            } else {
                return PASSWORD_NOT_RESET;
            }
        } else {
            return VERIFICATION_CODE_WRONG;
        }
    }

    public function deleteUser($id) {
        if($this->isUserExists($id)) {
            $statement = $this->conn->prepare("DELETE FROM ".$this->table_students." WHERE id = ?");
            $statement->bind_param("i", $id);

            if($statement->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getAllUser() {
        $statement = $this->conn->prepare("SELECT id, name, email, created_at FROM ".$this->table_students." ORDER BY created_at DESC");
        $statement->execute();
        $statement->bind_result($id, $name, $email, $created_at);
        $all_user = array();

        while($statement->fetch()) {
            $user = array();
            $user['id'] = $id;
            $user['name'] = $name;
            $user['email'] = $email;
            $user['created_at'] = $created_at;

            array_push($all_user, $user);
        }

        $statement->close();
        return $all_user;
    }

    public function getTopics() {
        $statement = $this->conn->prepare("SELECT id, topic_name, image_path, supervisor_initial, description_one, description_two, video_path FROM ".$this->table_topics." ORDER BY id DESC");
        $statement->execute();
        $statement->bind_result($id, $topic_name, $image_path, $supervisor_initial, $description_one, $description_two, $video_path);
        
        $all_topic = array();
        while($statement->fetch()) {
            $topic = array();
            $topic['id'] = $id;
            $topic['topic_name'] = $topic_name;
            $topic['image_path'] = $image_path;
            $topic['supervisor_initial'] = $supervisor_initial;
            $topic['description_one'] = $description_one;
            $topic['description_two'] = $description_two;
            $topic['video_path'] = $video_path;

            array_push($all_topic, $topic);
        }

        $statement->close();
        return $all_topic;
    }

    public function getSupervisors() {
        $statement = $this->conn->prepare("SELECT id, supervisor_name, supervisor_initial, designation, supervisor_image, phone, email, research_area, training_experience, membership, publication_project, profile_link FROM ".$this->table_supervisors);
        $statement->execute();
        $statement->bind_result($id, $supervisor_name, $supervisor_initial, $designation, $supervisor_image, $phone, $email, $research_area, $training_experience, $membership, $publication_project, $profile_link);
        
        $all_supervisor = array();
        while($statement->fetch()) {
            $supervisor = array();
            $supervisor['id'] = $id;
            $supervisor['supervisor_name'] = $supervisor_name;
            $supervisor['supervisor_initial'] = $supervisor_initial;
            $supervisor['designation'] = $designation;
            $supervisor['supervisor_image'] = $supervisor_image;
            $supervisor['phone'] = $phone;
            $supervisor['email'] = $email;
            $supervisor['research_area'] = $research_area;
            $supervisor['training_experience'] = $training_experience;
            $supervisor['membership'] = $membership;
            $supervisor['publication_project'] = $publication_project;
            $supervisor['profile_link'] = $profile_link;

            array_push($all_supervisor, $supervisor);
        }

        $statement->close();
        return $all_supervisor;
    }

    public function getUserByEmial($email) {
        $statement = $this->conn->prepare("SELECT id, name, email, user_role, created_at FROM ".$this->table_students." WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $statement->bind_result($id, $name, $email, $user_role, $created_at);
        $statement->fetch();
        $statement->close();

        $user = array();
        $user['id'] = $id;
        $user['name'] = $name;
        $user['email'] = $email;
        $user['user_role'] = $user_role;
        $user['created_at'] = $created_at;

        return $user;
    }

    private function updatePasswordStatus($email, $password_status) {
        $statement = $this->conn->prepare("UPDATE ".$this->table_students." SET password_status = ? WHERE email = ?");
        $statement->bind_param("is", $password_status, $email);

        if($statement->execute()) {
            return true;
        } else {
            return false;
        }
    }

    private function getPasswordByEmial($email) {
        $statement = $this->conn->prepare("SELECT password FROM ".$this->table_students." WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $statement->bind_result($password);
        $statement->fetch();
        $statement->close();

        return $password;
    }

    private function getTokenByEmial($email) {
        $statement = $this->conn->prepare("SELECT token FROM ".$this->table_students." WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $statement->bind_result($token);
        $statement->fetch();
        $statement->close();

        return $token;
    }

    private function isEmailExistsWtihUserRole($email, $user_role) {
        $statement = $this->conn->prepare("SELECT id FROM ".$this->table_students." WHERE email = ? AND user_role = ?");
        $statement->bind_param("ss", $email, $user_role);
        $statement->execute();
        $statement->store_result();

        $num_of_rows = $statement->num_rows;
        $statement->free_result();
        $statement->close();

        if($num_of_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function isEmailExists($email) {
        $statement = $this->conn->prepare("SELECT id FROM ".$this->table_students." WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $statement->store_result();

        $num_of_rows = $statement->num_rows;
        $statement->free_result();
        $statement->close();

        if($num_of_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function isUserExists($id) {
        $statement = $this->conn->prepare("SELECT email FROM ".$this->table_students." WHERE id = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $statement->store_result();

        $num_of_rows = $statement->num_rows;
        $statement->free_result();
        $statement->close();

        if($num_of_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function isEmailAndVerificationCodeMatch($email, $verification_code) {
        $statement = $this->conn->prepare("SELECT id FROM ".$this->table_students." WHERE email = ? AND verification_code = ?");
        $statement->bind_param("si", $email, $verification_code);
        $statement->execute();
        $statement->store_result();

        $num_of_rows = $statement->num_rows;
        $statement->free_result();
        $statement->close();

        if($num_of_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function isPasswordStatusUpdated($email) {
        $statement = $this->conn->prepare("SELECT password_status FROM ".$this->table_students." WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $statement->bind_result($password_status);
        $statement->fetch();
        $statement->close();

        if($password_status == 1) {
            return true;
        } else {
            return false;
        }
    }

    private function checkVerificationCode($email, $verification_code) {
        $statement = $this->conn->prepare("SELECT id FROM ".$this->table_students." WHERE verification_code = ? AND email = ?");
        $statement->bind_param("is", $verification_code, $email);
        $statement->execute();
        $statement->store_result();

        $num_of_rows = $statement->num_rows;
        $statement->free_result();
        $statement->close();

        if($num_of_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}

?>