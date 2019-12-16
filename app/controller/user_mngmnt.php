<?php

class user_mngmnt extends Controller {

    public function index() {
        $this->prepare_parts();
        $html = $this->construct_table();
        $this->params['obsah'] = $html;
        $this->render();
    }

    function construct_table() {
        $html = "";
        $users = $this->model->get_all_users();

        $html .= "\n<table class='table table-striped'>\n<tbody>\n";
        foreach ($users as $item){
            $html .= "<tr>\n
                        <td scope='row' class='align-middle role-user'>".$item['username']."</td>\n
                        <td>".$this->construct_select($item['role'])."</td>\n
                        <td><input type='button' value='Změň roli' class='role-changer'></td>\n";
        }
        $html .= "</tbody>\n</table>\n";

        return $html;
    }

    function construct_select($role) {
        $html = "<select class='role-select'>\n";
        for($i = 1; $i <= 3; $i++) {
            if ($i == $role) {
                switch ($i) {
                    case 1: $html .= "<option value='".$i."' disabled selected value>Autor</option>\n"; break;
                    case 2: $html .= "<option value='".$i."' disabled selected value>Recenzent</option>\n"; break;
                    case 3: $html .= "<option value='".$i."' disabled selected value>Admin</option>\n"; break;
                }
                continue;
            }

            switch ($i) {
                case 1: $html .= "<option value='".$i."'>Autor</option>\n"; break;
                case 2: $html .= "<option value='".$i."'>Recenzent</option>\n"; break;
                case 3: $html .= "<option value='".$i."'>Admin</option>\n"; break;
            }

        }
        $html .= "</select>\n";

        return $html;
    }

    public function change_role() {
        $username = $_POST['username'];
        $role = $_POST['role'];

        $this->model->alter_role($username, $role);
    }
}