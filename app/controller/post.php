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

        echo "<script>console.log('hello?')</script>";
        echo "submitting";

        $this->model->submit_form($first, $second, null);
    }
}