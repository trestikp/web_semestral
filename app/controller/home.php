<?php

class Home extends Controller {

    public function index() {
        $this->prepare_parts();
        $this->params['obsah'] = file_get_contents('../app/view/static/home.html');
        $this->render();

//        $this->model->submit_post("mock", "ok", null);
    }

    public function not_logged_in() {
        $this->prepare_parts();
        $this->params['obsah'] = file_get_contents('../app/view/static/for_logged.html');
        $this->render();
    }

    public function insufficient_permissions() {
        $this->prepare_parts();
        $this->params['obsah'] = file_get_contents('../app/view/static/insufficient_role.html');
        $this->render();
    }
}