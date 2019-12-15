<?php

class R_mngmnt extends Controller {

    public function index() {
        $this->prepare_parts();
        $this->params['obsah'] = "Review managment";
        $this->render();
    }
}