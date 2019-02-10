<?php

class DbOperations {
    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/DbConnection.php';

        $db = new DbConnection();
        $this->conn = $db->connect();
    }

    public function createAccount($email, $password, $verification_code, $status) {
        if(!$this->isEmailExists($email)) {
            $statement = $this->conn->prepare("INSERT INTO students (email, password, verification_code, status) VALUES(?, ?, ?, ?)");
            $statement->bind_param("ssii", $email, $password, $verification_code, $status);

            if($statement->execute()) {
                return USER_CREATED;
            } else {
                return USER_FAILURE;
            }
        }

        return USER_EXISTS;
    }

    public function userLogin($email, $password) {
        if($this->isEmailExists($email)) {
            $hash_password = $this->getUserPasswordByEmial($email);

            if(password_verify($password, $hash_password)) {
                return USER_AUTHENTICATED;
            } else {
                return PASSWORD_DO_NOT_MATCH;
            }
        } else {
            return USER_NOT_FOUND;
        }
    }

    private function getUserPasswordByEmial($email) {
        $statement = $this->conn->prepare("SELECT password FROM students WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $statement->bind_result($password);
        $statement->fetch();

        return $password;
    }

    public function getUserByEmial($email) {
        $statement = $this->conn->prepare("SELECT id, email, verification_code, status, created_at FROM students WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $statement->bind_result($id, $email, $verification_code, $status, $created_at);
        $statement->fetch();

        $user = array();
        $user['id'] = $id;
        $user['email'] = $email;
        $user['verification_code'] = $verification_code;
        $user['status'] = $status;
        $user['created_at'] = $created_at;

        return $user;
    }

    private function isEmailExists($email) {
        $statement = $this->conn->prepare("SELECT id FROM students WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $statement->store_result();

        return $statement->num_rows > 0;
    }
}

?>