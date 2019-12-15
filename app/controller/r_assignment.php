<?php

class R_assignment extends Controller {

    public function index() {
        $this->prepare_parts();
        $html = $this->construct_table();
        $this->params['obsah'] = $html;
        $this->render();
    }

    // count select results
//    $sql = "SELECT COUNT(*) FROM review_queue WHERE post=3";
//SELECT p.title FROM posts AS p, review_queue AS rq WHERE (SELECT COUNT(*) FROM review_queue WHERE post=3)<=3 AND rq.id=p.id AND rq.published=0;
// select titles where review count is <=3 and isn't published
//SELECT p.title FROM posts AS p, review_queue AS rq WHERE (SELECT COUNT(*) FROM review_queue WHERE post=p.id)<=3 AND rq.id=p.id AND p.published=0;
//in foreach call get_reviewers on every post
    function construct_table() {
        $html = "";
        $posts = $this->model->get_review_assignment_posts();

        $html .= "\n<table class='table table-striped'>\n<tbody>\n";
        foreach ($posts as $item){
            $html .= "<tr>\n
                        <td scope='row' class='align-middle'>".$item['title']."</td>\n";
            $reviewers = $this->model->get_reviewers_of_post($item['id']);
            $html .= "<td>\n<table class='w-100'>\n";
            for($i = 0; $i < 3; $i++) {
                $html .= "<tr class='w-100'>\n";
                if ($i < count($reviewers)) {
                    $html .= "<td class='w-100'>".$reviewers[$i]['username']."</td>\n";
                    switch ($reviewers[$i]['reviewed']) {
                        case 0: $html .= "<td scope='row'>Zatím nehodnoceno</td>\n"; break;
                        case 1: $html .= "<td scope='row'>Ohodnoceno</td>\n"; break;
                    }
                } else {
                    $free_r = $this->model->get_free_reviewers($item['id']);
                    $html .= "<td>\n<select id='r_".$item['id']."_select".$i."'>\n";
                              $html .= "<option disabled selected value> -- zvolte -- </option>";
                              foreach($free_r as $rec) {
                                  $html .= "<option value=\"".$rec['id']."\">".$rec['username']."</option>\n";
                              }
                    $html .= "</select>\n</td>\n";
                    $html .= "<td>\n
                                <input class='r_adding' type='button' id='r_".$item['id']."_button".$i."' value='Přidat recenzeta'>
                              </td>\n";
                }
                $html .= "</tr>\n";
            }
            $html .= "</table>\n</td>\n</tr>\n";
        }
        $html .= "</tbody>\n</table>\n";

        return $html;
    }

    public function add_review_queue() {
        $p_id = $_POST['p_id'];
        $r_id = $_POST['r_id'];

        $this->model->assign_reviewer($r_id, $p_id);
    }
}