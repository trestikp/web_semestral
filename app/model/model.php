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
        $sql = "SELECT author, published, title FROM posts WHERE published = 1";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function get_users_posts() {
        $sql = "SELECT title FROM posts WHERE author = ".$_SESSION['id'];
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function get_posts_to_review() {
//        $id = $_SESSION['id'];
//        $sql = "SELECT p.title FROM posts as p, review_queue as rq WHERE p.id=rq.post AND rq.publish=0 AND rq.reviewer=".$id;
        $sql = "SELECT p.title FROM posts as p, review_queue as rq WHERE p.id=rq.post AND rq.publish=0 AND rq.reviewer=".$_SESSION['id'];
        $statement = $this->db->prepare($sql);
//        $statement->bindParam(':id', $_SESSION['id']);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function get_post_by_title($title) {
        $sql = "SELECT a.username, p.title, p.text, p.file FROM posts as p, users as a 
                WHERE title = \"$title\" AND a.id = p.author";
//        $sql = "SELECT author.username, title, text, file FROM posts, author WHERE title = \"$title\"";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}