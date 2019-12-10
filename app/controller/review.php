<?php

class Review extends Controller {

    public function index() {
        if ($_SESSION["logged"] == false) {
            header('Location: /web_semestral/public/home/index');
        }

        $this->prepare_parts();
        $html = $this->construct_table();
//        $this->params['obsah'] = file_get_contents('../app/view/static/review.html');
        $this->params['obsah'] = $html;
        $this->render();
    }

    private function construct_table() {
        $html = "";
        $posts = $this->model->get_posts_to_review();

        $html .= "\n<table class='table table-striped'>\n<tbody>\n";
        foreach ($posts as $item){
            $html .= "<tr><th scope='row'><a href='click_item'>".$item['title']."</a></th></tr>\n";
        }
        $html .= "</tbody>\n</table>\n";

        return $html;
    }

    public function click_item() {
        echo "you clicked this";
    }
}