<?php

class Login_controller extends Controller {

    public function index() {
        echo "YOU ARE NOT SUPPOSED TO BE THERE (login_controller/index)";
    }

    public function verify() {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $rc = $this->model->login($username, $password);

        if ($rc == 3) {
            echo "NO";
        }
        if ($rc == 0) {
            echo "YES";
//            session_start();
        }
    }

    function log_in_user() {
        header("Refresh:0");
//        echo "logging in";
//        $this->prepare_parts();
//        $this->render();
    }
}