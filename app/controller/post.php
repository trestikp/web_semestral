<?php

class Post extends Controller {

    public function index() {
        // if a users isn't logged in redirect to home
        if ($_SESSION["logged"] == false) {
            header('Location: /web_semestral/public/home/index');
        }

        $this->prepare_parts();
        $form = file_get_contents('../app/view/static/post_form.html');
        $html = $this->twig->render('post.html', ['body' => $form]);
        $this->params['obsah'] = $html;
        $this->render();
    }

    public function submit_post() {
        $first = $_GET['post_name'];
        $second = $_GET['post_desc'];

        //TODO: get file!
        $this->model->submit_post($first, $second, '');
    }

    public function submit_success() {
        if ($_SESSION["logged"] == false) {
            header('Location: /web_semestral/public/home/index');
        }

        $this->prepare_parts();
        $str = '/web_semestral/public/post/index';
        $html = "<dl>
                    <dd>
                        <p>Váš příspěvek byl úspěšně odeslán.<br>
                        Stav zveřejnění příspěvku můžete vidět v sekci \"Mé příspěvky\"</p>
                    </dd>
                    <dt>
                        <dd>
                            <input class='float-left' id='my_posts_red' type='button' value='Mé příspěvky'>
                            <input class='float-right' id='new_post_red' type='button' value='Napsat další příspěvek'>
                        </dd>
                    </dt>
                 </dl>";
        $this->params['obsah'] = $html;
        $this->render();
    }
}