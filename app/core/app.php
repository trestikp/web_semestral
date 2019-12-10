<?php

class App {
    protected $controller = 'home';

    protected $method = 'index';

    protected $url_params = [];

    public function __construct() {
        $this->parseURL();
        $this->createPage();

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
                    unset($url[0]);

                    // If controller is set and exists, checks for existence of method. If second part of url
                    // isn't set, returns, because parameters are not expected.
                    if(isset($url[1])) {
                        $this->method = $url[1];
                        unset($url[1]);

                        // The rest of the array as params
                        $this->url_params = $url ? array_values($url) : [];
                    } else {
                        /* If method isn't set assume index (default) method */
                        $this->method = 'index';
                        return;
                    }
                } else {
                    /* Set to error controller (something like page doesn't exit) */
                    //TODO: controller error
                }
            } else {
                /* If controller isn't set assume home (default) controller */
                $this->controller = 'home';
                return;
            }
        }
    }

    protected function createPage() {
        /* Already checked for file existence in url parsing */
        require_once '../app/controller/'.$this->controller.'.php';
        $this->controller = new $this->controller;

        /* If acquired method doesn't exists use error method */
        if(!method_exists($this->controller, $this->method)) {
            //TODO: method error
            $this->method = 'index';
        }

        /* Parameter handling? */
    }
}