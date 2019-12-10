<?php

class Home extends Controller {

    public function index() {
        $this->prepare_parts();
        $this->params['obsah'] = file_get_contents('../app/view/static/home.html');
        $this->render();

//        $this->model->submit_post("mock", "ok", null);
    }
}