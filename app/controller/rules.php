<?php

class Rules extends Controller {

    public function index() {
        $this->prepare_parts();
        $this->params['obsah'] = file_get_contents('../app/view/static/rules.html');
        $this->render();
    }
}