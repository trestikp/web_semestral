<?php

class R_mngmnt extends Controller {

    public function index() {
        $this->prepare_parts();
        $html = construct_table();
        $this->params['obsah'] = $html;
        $this->render();
    }

    function construct_table() {

    }
}

class ReviewManagment {
    private $p_id;
    private $reviews = array();
    private $accept_btn;
    private $deny_btn;

    function set_p_id($p_id) {
        $this->p_id = $p_id;
        $this->construct_accept();
        $this->construct_deny();
    }

    function set_review($reviews) {
        $this->reviews = $reviews;
    }

    function construct_accept() {
        $this->accept_btn = "<input type='button' id='r_accept".$this->p_id."'>";
    }

    function construct_deny() {
        $this->deny_btn = "<input type='button' id='r_deny".$this->p_id."'>";
    }
}