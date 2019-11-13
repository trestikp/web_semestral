<?php

//include_once '../app/controller/nav_subcontroller.php';
//include_once '../app/controller/form_subcontroller.php';
//include_once '../app/inc/db_info.php';

//require_once "../app/controller/nav_subcontroller.php";
//require_once "../app/controller/form_subcontroller.php";
//require_once "../app/inc/db_info.php";

require_once dirname(__FILE__).'/../controller/nav_subcontroller.php';
require_once dirname(__FILE__)."/../controller/form_subcontroller.php";

//require_once "/web_semestral/app/controller/nav_subcontroller.php";
//require_once "/web_semestral/app/controller/form_subcontroller.php";
//require_once "/web_semestral/app/inc/db_info.php";

class Controller {

    protected $twig;

    protected $nav;

    protected $log_form;

//    protected $log_error;

    protected $params;

    protected $model;

    protected $db;

    public function __construct() {
        $this->params = array();
        $this->params['obsah'] = null;
        $this->params['nav'] = null;
        $this->params['log_form'] = null;
        $this->params['log_error'] = null;
        $this->nav = new Nav();
        $this->log_form = new LoginForm();
        $this->loadTemplate();
    }

    protected function loadTemplate() {
        require_once '../app/vendor/autoload.php';

        $loader = new Twig\Loader\FilesystemLoader('../app/view/templates');
        $this->twig = new Twig\Environment($loader);
    }

    protected function render() {
        echo $this->twig->render('main_template.html', array('obsah' => $this->params['obsah'], 'nav' => $this->params['nav'],
                                 'log_form' => $this->params['log_form'], 'log_error' => $this->params['log_error']));
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