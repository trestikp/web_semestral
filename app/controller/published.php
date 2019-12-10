<?php

class Published extends Controller {

    public function index() {
        $this->prepare_parts();
        $this->params['obsah'] = file_get_contents('../app/view/static/published.html');
        $this->render();
    }
}