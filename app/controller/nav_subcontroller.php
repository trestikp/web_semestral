<?php

class Nav {

    private $nav;

    public function __construct() {
        $this->nav = '';
    }

    /*
     * @param $user should have following values:
     * 0 - no user logged in
     * 1 - author is logged in
     * 2 - reviewer is logged in
     * 3 - admin is logged in
     */
    public function create_nav($user) {
        $is_valid = true;
        if($user < 0 || $user > 3) {
            // TODO: redirect this to some error output
            echo 'user doesn\'t belong to any known group';
            $is_valid = false;
        }

//        echo "creating nav for user $user\n";


        // TODO: if the number is invalid - DO NOT change the nav - not logged user could get admin nav!!
        // basically useless if, 0 is (should be) always done
        if(0 <= $user) {
            $this->add_nav_element('/web_semestral/public/home/index', 'Úvod');
            $this->add_nav_element('/web_semestral/public/published/index', 'Příspěvky');
            $this->add_nav_element('/web_semestral/public/rules/index', 'Pravidla');
            $this->add_nav_element('/web_semestral/public/us/index', 'O nás');
        }

        if(1 <= $user) {
            $this->add_nav_element('/web_semestral/public/post/index', 'Přidat příspěvek');
            $this->add_nav_element('/web_semestral/public/my_posts/index', 'Mé příspěvky');
        }

        if(2 <= $user) {
            $this->add_nav_element('/web_semestral/public/review/index', 'Review příspěvku');
        }

        if(3 <= $user) {
            $this->add_nav_element('/web_semestral/public/user_mngmnt/index', 'Spravuj uživatele');
        }
    }

    public function get_nav() {
        return $this->nav;
    }

    private function add_nav_element($href, $title) {
        $is_active = '';
        $this->nav = $this->nav."<li class='page nav-item list-unstyled'><a id='link' class='nav-link $is_active' href=$href>$title</a></li>\n";
    }
}