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
            $this->params["log_error"] = "<p>Incorrect password!</p>";
//            $this->render();
//            $this->render_log_error("<p>Incorrect password!</p>");
        }
        if ($rc == 1) {
            $this->params["log_error"] = "<p>User doesn't exist!</p>";
//            $this->render();
//            $this->render_log_error("<p>User doesn't exist!</p>");
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