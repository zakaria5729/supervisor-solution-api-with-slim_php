<?php

class DbConnection {
    private $conn;

    function connect() {
        include_once dirname(__FILE__) . '/constants.php';
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if(mysqli_connect_error()) {
            echo "Failed to connect: " . mysqli_connect_error();
            mysqli_close($this->conn);

            return null;
        }

        return $this->conn;
    }
}

?>