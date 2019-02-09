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

    public function isEmailExists($email) {
        $statement = $this->conn->prepare("SELECT id FROM students WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $statement->store_result();

        return $statement->num_rows > 0;
    }
}

?>