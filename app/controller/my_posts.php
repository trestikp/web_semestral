<?php

class My_posts extends Controller {

    public function index() {
        $this->prepare_parts();
        $html = $this->construct_posts();
        $this->params['obsah'] = $html;
        $this->render();
    }

    /**
     * This function is identical to published read_post()
     * The thought is changing this to allow post editing.
     */
    public function read_my_post() {
        $this->prepare_parts();
        $posts = $this->model->get_post_by_title($this->url_params[0]);

        //presuming only one post with the same title name and author
        $author = $posts[0]["username"];
        $title = $posts[0]["title"];
        $text = $posts[0]["text"];

        $file_html = '';
        if ($posts[0]['file'] != '') {
            $file_html = '<div><b>Soubor pdf: </b>';
            $file = $posts[0]["file"];

            if (file_exists("../app/uploads/$file"))
                $file_html .= "<embed src=\"/web_semestral/app/uploads/$file\" type='application/pdf'
                                width='100%' height='1080px'/>";
            else
                $file_html .= "Tento příspěvek měl připnutý pdf soubor.
                                    Tento soubor se ale bohužel nepodařilo otevřít.";
        }
        $file_html .= '</div>';

        $html = $this->twig->render('post_reader.html', ["post_title" => $title,
            "author" => $author, "post_text" => $text,
            "post_file" => $file_html]);
        $this->params['obsah'] = $html;
        $this->render();
    }

    function construct_posts() {
        $html = "";
        $posts = $this->model->get_users_posts();

        if (empty($posts)) {
            $html = "Zatím jste nenapsal žadný příspěvek!";
        }

        $html .= "\n<table class='table table-striped'>\n<tbody>\n";
        /*
         * state 0 = just submitted - waiting for reviewer assignments
         * state 1 = waiting for reviews
         * state 2 = waiting for decision
         * state 3 = accepted/denied
         */
        foreach ($posts as $item){
//            <td><a href='read_my_post/".$item['title']."'>".$item['title']."</a></td>
            $html .= "<tr>
                        <td><a href='read_my_post/".$item['title']."'>".$item['title']."</a></td>";

            switch ($item['state']) {
                case 0: $html .= "<td>Waiting for reviewers to be assigned</td>"; break;
                case 1: $html .= "<td>Waiting for reviewers to review</td>"; break;
                case 2: $html .= "<td>Waiting for admin's decision</td>"; break;
                case 3: if ($item['published'] == 1) {
                            $html .= "<td>Published</td>";
                            break;
                        } else {
                            $html .= "<td>Denied</td>";
                            break;
                        }
            }
            $html .= "</tr>\n";
        }
        $html .= "</tbody>\n</table>\n";

        return $html;
    }
}