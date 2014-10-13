<?php
    if($_SESSION['loggedIn'] == false) {
        if(isset($_COOKIE['persist'])){
            $table = "users";
            $select['user_id'] = $_COOKIE['user_id'];
            $sort['user_id'] = "ASC";
            $result = $database->select($table, $select, $sort);
            if (count($result) != 1) {
                $page->html .= $alert->displayError("Error locating username");
                $error = true;
            }
            if(!$error) {
                $dbUsername = $result[0]['username'];
                $dbPassword = $result[0]['password'];
                $md5 = md5($dbUsername + $dbPassword);

                if($_COOKIE['persist'] == $md5) {
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['username'] = $result[0]['username'];
                    $_SESSION['user_level'] = $result[0]['user_level'];
                }
                else {
                    $page->html .= $alert->displayError("Error locating username");
                }
            }
        }
    }
?>