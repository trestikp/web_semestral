<?php

class Home extends Controller {

    public function index() {
        $params = array();
        $params['obsah'] = file_get_contents('../app/view/static/uvod.html');
        $this->nav->create_nav(0);
        $params['nav'] = $this->nav->get_nav();
        $params['log_form'] = $this->log_form->get_log_form();
        $this->render($params);
    }
}