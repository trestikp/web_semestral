<?php

class Model {

    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function login($username, $password) {
        $sql = "SELECT username, password, role, email FROM users WHERE username=\"$username\"";
        $statement = $this->db->prepare($sql);

//        if ($statement == false) {
//            $err = $this->db->errorInfo();
//            error_log($err[2]);
//        }

        $statement->execute(array(':username'=>$username));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

//        echo $sql."\n";
//        print_r($result);
        if (count($result) < 1) {
            // if there is no result -> user doesn't exist
            return 1;
        } else if (count($result) > 1) {
            // if there is more then 1 result -> more of the same usernames
            // prevent this!
            return 2;
        } else {
            if ($password == $result[0]["password"]) {
                $_SESSION["username"] = $result[0]["username"];
                $_SESSION["role"] = $result[0]["role"];
                $_SESSION["email"] = $result[0]["email"];
                // for testing
                return 0;
            } else {
                // wrong password
                return 3;
            }
        }
    }
}