<?php

include_once '../app/controller/nav_subcontroller.php';

class Controller {

    protected $twig;

    protected $nav;

    public function __construct() {
        $this->nav = new Nav();
        $this->loadTemplate();
    }

    protected function loadTemplate() {
        require_once '../app/vendor/autoload.php';

        $loader = new Twig\Loader\FilesystemLoader('../app/view/templates');
        $this->twig = new Twig\Environment($loader);
    }

    protected function render($params) {
        echo $this->twig->render('main_template.html', array('obsah' => $params['obsah'], 'nav' => $params['nav'],
                                 'log_form' => $params['log_form']));
    }

//    protected function get_navigation($user) {
//        $this->nav->create_nav($user);
//        return $this->nav->get_nav();
//    }

}