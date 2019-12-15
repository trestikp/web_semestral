<?php

class user_mngmnt extends Controller {

    public function index() {
        $this->prepare_parts();
        $this->params['obsah'] = "User managment";
        $this->render();
    }
}