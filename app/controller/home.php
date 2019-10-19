<?php

class Home extends Controller {

    public function index() {
        $params = array();
        $params['obsah'] = file_get_contents('../app/view/static/uvod.html');
//        $params['nav'] = null;
        $this->nav->create_nav(0);
        $params['nav'] = $this->nav->get_nav();
//        $params['nav'] = 'Hello, world!';
        $params['log_form'] = null;
        $this->render($params);
    }
}