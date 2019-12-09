<?php

class LoginForm {

    private $log_form;

    public function __construct() {
        $this->log_form = file_get_contents('../app/view/static/login_form.html');
    }

    public function get_log_form() {
        return $this->log_form;
    }

    public function change_to_logged($username) {
        $this->log_form = "<dl>
                                <dt><p>Přihlášený uživatel: ".$username."</p></dt>
                                <dt><input type='button' name='logout' id='logout' value='Odhlásit'
                                 onclick='logOut()'></dt>
                           </dl>";
    }
}