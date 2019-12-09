<?php

class Rules extends Controller {

    public function index() {
        $this->nav->create_nav(0);
        $this->params['obsah'] = file_get_contents('../app/view/static/rules.html');
        $this->params['nav'] = $this->nav->get_nav();
        $this->params['log_form'] = $this->log_form->get_log_form();
        $this->render();
    }
}