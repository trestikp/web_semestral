<?php

include_once '../app/controller/nav_subcontroller.php';
include_once '../app/controller/form_subcontroller.php';
include_once '../app/inc/db_info.php';

class Controller {

    protected $twig;

    protected $nav;

    protected $log_form;

    protected $model;

    protected $db;

    public function __construct() {
        $this->nav = new Nav();
        $this->log_form = new LoginForm();
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

    protected function createModel() {
        try {
            $this->db = new PDO("mysql:host".DB_HOST.";dbname:".DB_NAME, DB_USER, DB_PASSWORD);
        } catch (PDOException $e) {
            echo "Failed to connect to database" . $e->getMessage();
            return;
        }

        require '../app/model/model.php';
        $this->model = new Model($this->db);
    }

}