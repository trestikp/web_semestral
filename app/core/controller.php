<?php

//include_once '../app/controller/nav_subcontroller.php';
//include_once '../app/controller/form_subcontroller.php';
//include_once '../app/controller/login_controller.php';
//include_once '../app/inc/db_info.php';

//require_once "../app/controller/nav_subcontroller.php";
//require_once "../app/controller/form_subcontroller.php";
//require_once "../app/inc/db_info.php";

require_once dirname(__FILE__)."/../controller/nav_subcontroller.php";
require_once dirname(__FILE__)."/../controller/form_subcontroller.php";
require_once dirname(__FILE__)."/../controller/login_controller.php";

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
        $this->createModel();
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
        require_once "../app/inc/db_info.php";
        try {
            $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
        } catch (PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
            return;
        }

        require_once '../app/model/model.php';
        $this->model = new Model($this->db);
    }

    protected function prepare_parts() {
        // generate appropriate nav
        if (isset($_SESSION["logged"])) {
            if ($_SESSION["logged"] == true) {
                switch ($_SESSION["role"]) {
                    // if author is logged in
                    case 1: $this->nav->create_nav(1); break;
                    // if reviewer is logged in
                    case 2: $this->nav->create_nav(2); break;
                    // admin logged in
                    case 3: $this->nav->create_nav(3); break;
                }
            }
        } else {
            $this->nav->create_nav(0);
        }
        $this->params['nav'] = $this->nav->get_nav();

        // generate appropriate "form"
        if(isset($_SESSION["logged"])) {
            if ($_SESSION["logged"] == true) {
                $this->log_form->change_to_logged($_SESSION["username"]);
            }
        } else {
            $this->log_form->__construct();
        }
        $this->params['log_form'] = $this->log_form->get_log_form();
    }
}