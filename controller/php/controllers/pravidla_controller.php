<?php

class pravidla_controller extends base_controller {

    public function index_action($params){
        $html = phpWrapperFromFile("controller/php/controllers/pravidla.php", $params);

        $this->render($html, $params);
    }
}