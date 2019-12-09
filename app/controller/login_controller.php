<?php

class Login extends Controller {

    public function verify() {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $rc = $this->model->login($username, $password);

        if ($rc == 3) {
            echo "NO\n";
        }
        if ($rc == 0) {
            echo "YES\n";
        }

        echo "konec\n";
    }
}