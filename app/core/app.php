<?php

class App {
    protected $controller = 'home';

    protected $method = 'index';

    protected $url_params = [];

    public function __construct() {
        require_once '../app/controller/home.php';
        $this->controller = new $this->controller;

        $this->parseURL();

        call_user_func_array([$this->controller, $this->method], $this->url_params);
    }

    protected function parseURL() {
        if(isset($_GET['url'])) {
            $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));

            // If controller name is set, checks for existence. Else returns (home stays as default value).
            // Maybe not needed, since checking if url is set?*
            if(isset($url[0])) {
                if(file_exists('../app/controller/'.$url[0].'.php')) {
                    $this->controller = $url[0];

                    require_once '../app/controller/'.$this->controller.'.php';
                    $this->controller = new $this->controller;

                    // If controller is set and exists, checks for existence of method. If second part of url
                    // isn't set, returns, because parameters are not expected.
                    if(isset($url[1])) {
                        if(method_exists($this->controller, $url[1])) {
                            $this->method = $url[1];

                            // Need to unset here, before params but not before method
                            unset($url[0], $url[1]);

                            // Checks if params exists, otherwise returns empty array.
                            $this->url_params = $url ? array_values($url) : [];
                        }
                    } else {
                        return;
                    }
                }
            } else {
                return;
            }
        }
    }
}