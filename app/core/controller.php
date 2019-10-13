<?php

class Controller {

    protected $twig;

    public function __construct() {
        $this->loadTemplate();
    }

    protected function loadTemplate() {
        require_once '../app/vendor/autoload.php';

        $loader = new Twig\Loader\FilesystemLoader('../app/view/templates');
        $this->twig = new Twig\Environment($loader);
        echo $this->twig->render('main_template.html', array());
    }

}