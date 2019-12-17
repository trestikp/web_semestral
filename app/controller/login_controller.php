<?php

class Login_controller extends Controller {

    public function verify() {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $rc = $this->model->login($username, $password);

        if ($rc == 3) {
//            $this->params["log_error"] = "<p>Incorrect password!</p>";
            echo 3;
        }
        if ($rc == 1) {
//            $this->params["log_error"] = "<p>User doesn't exist!</p>";
            echo 1;
        }
    }

    function log_in_user() {
        header("Refresh:0");
    }

    function log_out_user() {
        $_SESSION["logged"] = false;
        header("Refresh:0");
    }
}