<?php

class Published extends Controller {

    public function index() {
        $this->prepare_parts();
        $html = $this->construct_posts();
        $this->params['obsah'] = $html;
        $this->render();
    }

    public function read_post() {
        $this->prepare_parts();

        if (empty($this->url_params)) {
            //TODO: some error
        }

        $posts = $this->model->get_post_by_title($this->url_params[0]);


        //presuming only one post with the title name
        $author = $posts[0]["username"];
        $title = $posts[0]["title"];
        // TODO: PDF to text
        $text = $posts[0]["text"];

        $html = $this->twig->render('post_reader.html', ["post_title" => $title,
                                    "author" => $author, "post_text" => $text]);
        $this->params['obsah'] = $html;
        $this->render();
    }

    private function construct_posts() {
        $html = "\n<h3>Seznam příspěvků</h3><br>\n";
        $posts = $this->model->get_all_published_posts();

        if (empty($posts)) {
            $html = "Vypadá to, že zatím nebyly zveřejněny žádné příspěvky.";
        }

        $html .= "\n<table class='table table-striped'>\n<tbody>\n";
        foreach ($posts as $item){
            $html .= "<tr>
                        <td scope='row'><a href='read_post/".$item['title']."'>".$item['title']."</a></td>
                        <td scope='row'>by: ".$item['username']."</td>
                      </tr>\n";
        }
        $html .= "</tbody>\n</table>\n";

        return $html;
    }
}