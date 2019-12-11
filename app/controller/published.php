<?php

class Published extends Controller {

    public function index() {
        $this->prepare_parts();
        $html = $this->construct_posts();
        $this->params['obsah'] = $html;
        $this->render();
    }

    private function construct_posts() {
        $html = "\n<h3>Vítej na webu konference o hrách!</h3><br>\n";
        $posts = $this->model->get_all_published_posts();

        if (empty($posts)) {
            $html = "Vypadá to, že zatím nebyly zveřejněny žádné příspěvky.";
        }

        $html .= "\n<table class='table table-striped'>\n<tbody>\n";
        foreach ($posts as $item){
            $html .= "<tr><th scope='row'><a href='#'>".$item['title']."</a></th></tr>\n";
        }
        $html .= "</tbody>\n</table>\n";

        return $html;
    }
}