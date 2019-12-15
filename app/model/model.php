<?php

class Model {

    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function login($username, $password) {
//        $sql = "SELECT username, password, role, email FROM users WHERE username=\"$username\"";
        $sql = "SELECT * FROM users WHERE username=\"$username\"";
        $statement = $this->db->prepare($sql);

//        if ($statement == false) {
//            $err = $this->db->errorInfo();
//            error_log($err[2]);
//        }

        $statement->execute();
        $result = $statement->fetchAll();
//        $statement->execute(array(':username'=>$username));
//        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

//        echo $sql."\n";
//        print_r($result);
        if (count($result) < 1) {
            // if there is no result -> user doesn't exist
            return 1;
        } else if (count($result) > 1) {
            // if there is more then 1 result -> more of the same usernames
            // prevent this!
            return 2;
        } else {
            if ($password == $result[0]["password"]) {
                $_SESSION["id"] = $result[0]["id"];
                $_SESSION["username"] = $result[0]["username"];
                $_SESSION["role"] = $result[0]["role"];
                $_SESSION["email"] = $result[0]["email"];
                $_SESSION["logged"] = true;
                // for testing
                return 0;
            } else {
                // wrong password
                return 3;
            }
        }
    }

    public function submit_post($title, $description, $file) {
        $sql = "INSERT INTO posts(author, title, text, file) VALUES (".$_SESSION['id'].",'$title', '$description', '$file')";
        $this->db->exec($sql);
//        $statement = $this->db->prepare($sql);
//        $statement->execute();
    }

    public function get_all_published_posts() {
        $sql = "SELECT author, published, title, username FROM posts, users WHERE published = 1 AND users.id = author";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function get_users_posts() {
        $sql = "SELECT title, state, published, file FROM posts WHERE author = ".$_SESSION['id'];
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function get_posts_to_review() {
//        $id = $_SESSION['id'];
//        $sql = "SELECT p.title FROM posts as p, review_queue as rq WHERE p.id=rq.post AND rq.publish=0 AND rq.reviewer=".$id;
        $sql = "SELECT p.title, rq.reviewed FROM posts as p, review_queue as rq WHERE
                p.id=rq.post AND rq.published=0 AND rq.reviewer=".$_SESSION['id']." ORDER BY rq.reviewed";
        $statement = $this->db->prepare($sql);
//        $statement->bindParam(':id', $_SESSION['id']);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function get_post_by_title($title) {
        $sql = "SELECT a.username, p.title, p.text, p.file, p.id FROM posts as p, users as a 
                WHERE title = \"$title\" AND a.id = p.author";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function username_occupied($username) {
        $sql = "SELECT * FROM users WHERE username=\"$username\"";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) >= 1) {
            // username already exists
            return true;
        } else {
            return false;
        }
    }

    public function add_user($username, $password, $email) {
        // no need to set role -> role is automatically set to 1 (author) by the db
        $sql = "INSERT INTO users(username, password, email) VALUES (\"$username\", \"$password\", \"$email\")";
        $statement = $this->db->prepare($sql);
        $statement->execute();
    }

    public function add_review($criterium_1, $criterium_2, $criterium_3, $overall, $post_id, $text) {
        $sql = "INSERT INTO reviews(post, reviewer, criterium1, criterium2, criterium3, overall, text)
                VALUES ($post_id, ".$_SESSION['id'].", $criterium_1, $criterium_2, $criterium_3, $overall, \"$text\")";
        $statement = $this->db->prepare($sql);
        $statement->execute();
    }

    public function set_as_reviewed($reviewer, $post_id) {
        $sql = "UPDATE review_queue SET reviewed=1 WHERE post=$post_id AND reviewer=$reviewer";
        $statement = $this->db->prepare($sql);
        $statement->execute();
    }

    public function is_reviewed($reviewer, $post_id) {
        $sql = "SELECT reviewed FROM review_queue WHERE post=$post_id AND reviewer=$reviewer";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result['reviewed'] == 1) {
//            $_SESSION['r_id'] =
            return true;
        } else {
            return false;
        }
    }

    public function update_review($criterium_1, $criterium_2, $criterium_3, $overall, $post_id, $text) {
        $sql = "UPDATE reviews SET criterium1=$criterium_1, criterium2=$criterium_2, criterium3=$criterium_3,
                overall=$overall, text=\"$text\" WHERE reviewer=".$_SESSION['id']." AND post=$post_id";
        $statement = $this->db->prepare($sql);
        $statement->execute();
    }

    public function get_review_assignment_posts() {
//        SELECT p.title, p.id, COUNT(*) FROM posts AS p JOIN review_queue AS rq ON rq.post=p.id
//	    GROUP BY p.id
//        HAVING COUNT(*)<3
        $sql = "SELECT p.title, p.id, COUNT(*) FROM posts AS p JOIN review_queue AS rq ON rq.post=p.id
	            GROUP BY p.id
                HAVING COUNT(*)<3";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public function get_reviewers_of_post($p_id) {
        $sql = "SELECT u.username, rq.reviewed FROM users AS u, review_queue AS rq WHERE
                u.id=rq.reviewer AND rq.post=$p_id";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    //SELECT DISTINCT u.username FROM users AS u, review_queue AS rq WHERE u.id NOT IN (SELECT DISTINCT u.id FROM users AS u, posts AS p, review_queue AS rq WHERE rq.post=3 AND u.id=rq.reviewer) AND u.role>1
    public function get_free_reviewers($p_id) {
        $sql = "SELECT DISTINCT u.username, u.id FROM users AS u, review_queue AS rq WHERE
                u.id NOT IN (SELECT DISTINCT u.id FROM users AS u, posts AS p, review_queue AS rq WHERE
                rq.post=$p_id AND u.id=rq.reviewer) AND u.role>1";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public function assign_reviewer($r_id, $p_id) {
        $sql = "INSERT INTO review_queue(reviewer, post) VALUES ($r_id, $p_id)";
        $statement = $this->db->prepare($sql);
        $statement->execute();
    }

    public function get_unpublished_reviewed() {
//        SELECT DISTINCT p.title, p.id, COUNT(*) FROM posts AS p JOIN review_queue AS rq ON rq.post=p.id WHERE
//		rq.reviewed=1 AND
//        p.published=0
//        GROUP BY rq.post
//        HAVING COUNT(*) >=3
        $sql = "SELECT DISTINCT p.title, p.id, COUNT(*) FROM posts AS p JOIN review_queue AS rq ON rq.post=p.id WHERE
		rq.reviewed=1 AND
        p.published=0
        GROUP BY rq.post
        HAVING COUNT(*) >=3";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }
}