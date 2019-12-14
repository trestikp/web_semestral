<?php

class My_posts extends Controller {

    public function index() {
        $this->prepare_parts();
        $html = $this->construct_posts();
        $this->params['obsah'] = $html;
        $this->render();
    }

    function construct_posts() {
        $html = "";
        $posts = $this->model->get_users_posts();

        if (empty($posts)) {
            $html = "Zatím jste nenapsal žadný příspěvek!";
        }

        $html .= "\n<table class='table table-striped'>\n<tbody>\n";
        /*
         * state 0 = just submitted - waiting for reviewer assignments
         * state 1 = waiting for reviews
         * state 2 = waiting for decision
         * state 3 = accepted/denied
         */
        foreach ($posts as $item){
            $html .= "<tr>
                        <td><a href='#'>".$item['title']."</a></td>";
            switch ($item['state']) {
                case 0: $html .= "<td>Waiting for reviewers to be assigned</td>"; break;
                case 1: $html .= "<td>Waiting for reviewers to review</td>"; break;
                case 2: $html .= "<td>Waiting for admin's decision</td>"; break;
                case 3: if ($item['published'] == 1) {
                            $html .= "<td>Published</td>";
                            break;
                        } else {
                            $html .= "<td>Denied</td>";
                            break;
                        }
            }
            $html .= "</tr>\n";
        }
        $html .= "</tbody>\n</table>\n";

        return $html;
    }
}