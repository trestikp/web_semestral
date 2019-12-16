<?php

class R_mngmnt extends Controller {

    private $objs = array();

    public function index() {
        $this->prepare_parts();
        $html = $this->construct_table();
        $this->params['obsah'] = $html;
        $this->render();
    }

    function construct_table() {
        $html = "";
        $posts = $this->model->get_unpublished_reviewed();
//        $objs = array();

        $html .= "\n<table class='table table-striped'>\n<tbody>\n";

        for ($i = 0; $i < count($posts); $i++) {
            $this->objs[$i] = new ReviewManagment($posts[$i]['id'], $posts[$i]['title'],
                                            $this->model->get_reviews_of_post($posts[$i]['id']));
        }

        foreach ($this->objs as $item) {
            $html .= "<tr>
                        <td scope='row' class='align-middle'><a href='review_post/".$item->get_id()."'>".$item->get_title()."</a></td>".
//                        <td>".$objs[$i]->get_reviews()[$i]['overall']."</td>
                "<td>".$this->construct_sub_table($item->get_reviews())."</td>".
                "<td>".$this->get_avarage_overall($item->get_reviews())."</td>".
                "<td class='align-middle'>".$item->get_accept()."<br>".$item->get_deny()."</td>\n";
            $html .= "</tr>\n";
        }


        $html .= "</tbody>\n</table>\n";

        return $html;
    }

    function construct_sub_table($reviews) {
        $html = "\n<table>
                    <tr>".
//                       <th>recenzent</th>
                       "<th>jaz.</th>
                       <th>téma</th>
                       <th>kval.</th>
                       <th>celk.</th>
                    </tr>";

        foreach ($reviews as $review) {
            $html .= "<tr>".
//                        <td>" . $review['username'] . "</td>
                        "<td>" . $review['criterium1'] . "</td>
                        <td>" . $review['criterium2'] . "</td>
                        <td>" . $review['criterium3'] . "</td>
                        <td>" . $review['overall'] . "</td>
                        <td><a href='show_review/".$review['id']."'>Zobrazit</a></td>
                    </tr>";
        }

         $html .= "</table>";

        return $html;
    }

    public function show_review() {
        $review = $this->model->get_review_by_id($this->url_params[0]);

        
//        $this->params['obsah'] = $review['text'];
//        $this->render();
    }

    function get_avarage_overall($reviews) {
        $sum = 0;
        $cnt = 0;

        foreach ($reviews as $rv) {
            $sum += $rv['overall'];
            $cnt++;
        }

        if ($cnt == 0) {
            $html = "<table><tr><th>Celkový<br>průměr</th></tr><tr><td>---</td></tr></table>";
        } else {
            $html = "<table><tr><th>Celkový<br>průměr</th></tr><tr><td>".round(($sum / $cnt), 2)."</td></tr></table>";
        }

        return $html;
    }

    public function accept() {
        $p_id = $_POST['p_id'];
        $p_title = $_POST['p_title'];

        $this->model->publish_post($p_id);
    }

    public function deny() {
        $p_id = $_POST['p_id'];
        $p_title = $_POST['p_title'];

        $this->model->deny_post($p_id);
    }

    function find_post($p_id, $p_title) {
        foreach ($this->objs as $item) {
            if ($item->get_id() == $p_id && $item->get_title() == $p_title) {
                return $item;
            }
        }
    }
}

class ReviewManagment {
    private $p_id;
    private $p_title;
    private $reviews = array();
    private $accept_btn;
    private $deny_btn;


    function __construct($p_id, $p_title, $reviews) {
        $this->p_id = $p_id;
        $this->p_title = $p_title;
        $this->reviews = $reviews;
        $this->construct_accept();
        $this->construct_deny();
    }
//    function set_p_id($p_id) {
//        $this->p_id = $p_id;
//        $this->construct_accept();
//        $this->construct_deny();
//    }
//
//    function set_p_title($p_title) {
//        $this->p_title = $p_title;
//    }
//
//    function set_review($reviews) {
//        $this->reviews = $reviews;
//    }

    function construct_accept() {
        $this->accept_btn = "<input type='button' id='r_accept_".$this->p_id."_".$this->p_title."' value='Přijmout'
                             class='r_manage_btn'>";
    }

    function construct_deny() {
        $this->deny_btn = "<input type='button' id='r_deny_".$this->p_id."_".$this->p_title."' value='Zamítnout'
                           class='r_manage_btn'>";
    }

    function get_reviews() {
        return $this->reviews;
    }

    function get_accept() {
        return $this->accept_btn;
    }

    function get_deny() {
        return $this->deny_btn;
    }

    function get_title() {
        return $this->p_title;
    }

    function get_id() {
        return $this->p_id;
    }
}