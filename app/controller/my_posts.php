<?php

class My_posts extends Controller {

    public function index() {
        $this->prepare_parts();
        $html = $this->construct_posts();
        $this->params['obsah'] = $html;
        $this->render();
    }

    function construct_posts() {
        $html = "";
        $posts = $this->model->get_users_posts();

        if (empty($posts)) {
            $html = "Zatím jste nenapsal žadný článek!";
        }

        $html .= "\n<table class='table table-striped'>\n<tbody>\n";
        foreach ($posts as $item){
            $html .= "<tr><th scope='row'><a href='#'>".$item['title']."</a></th></tr>\n";
        }
        $html .= "</tbody>\n</table>\n";

        return $html;
    }
}