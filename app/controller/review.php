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
            $html .= "<tr>
                        <td scope='row'><a href='review_post/".$item['title']."'>".$item['title']."</a></td>";
            switch ($item['reviewed']) {
                case 0: $html .= "<td scope='row'>Zatím nehodnoceno</td>"; break;
                case 1: $html .= "<td scope='row'>Ohodnoceno</td>"; break;
            }
            $html .= "</tr>\n";
        }
        $html .= "</tbody>\n</table>\n";

        return $html;
    }

    public function review_post() {
        $this->prepare_parts();

        $posts = $this->model->get_post_by_title($this->url_params[0]);
        $_SESSION['p_id'] = $posts[0]['id'];

        $file_html = '';
        if ($posts[0]['file'] != '') {
            $file_html .= '<div><b>Soubor pdf: </b>';
            $file = $posts[0]['file'];

            if (file_exists("../app/uploads/$file"))
                $file_html .= "<embed src=\"/web_semestral/app/uploads/$file\" type='application/pdf'
                                width='100%' height='1080px'/>";
            else
                $file_html .= "Tento příspěvek měl připnutý pdf soubor.
                                    Tento soubor se ale bohužel nepodařilo otevřít.";
        }
        $file_html .= '</div>';

        $html = $this->twig->render('review_post.html', ['post_title' => $posts[0]['title'],
                                    'author' => $posts[0]['username'], 'post_text' => $posts[0]['text'],
                                    'post_file' => $file_html]);

        $this->params['obsah'] = $html;
        $this->render();

//        if ($this->model->is_reviewed($_SESSION['id'], $_SESSION['p_id'])) {
//            echo "sc";
//        }
    }

    public function submit_review() {
        $c1 = $_POST['criterium_1'];
        $c2 = $_POST['criterium_2'];
        $c3 = $_POST['criterium_3'];
        $ol = $_POST['overall'];
        $text = $_POST['review_comment'];

        if ($this->model->is_reviewed($_SESSION['id'], $_SESSION['p_id'])) {
            $this->model->update_review($c1, $c2, $c3, $ol, $_SESSION['p_id'], $text);
        } else {
            $this->model->add_review($c1, $c2, $c3, $ol, $_SESSION['p_id'], $text);
            $this->model->set_as_reviewed($_SESSION['id'], $_SESSION['p_id']);

        }

        $_SESSION['p_id'] = null;
    }

    public function success() {
        if ($_SESSION["logged"] == false) {
            header('Location: /web_semestral/public/home/index');
        }

        $this->prepare_parts();

        $html = $html = "<dl>
                    <dd>
                        <p>Hodnocení úspěšně odesláno.<br></p>
                    </dd>
                    <dt>
                        <dd>
                            <input class='float-left' id='goto_reviews' type='button' value='Zpět na hodnocení'>
                        </dd>
                    </dt>
                 </dl>";

        $this->params['obsah'] = $html;
        $this->render();
    }
}