<?php

function redirect($location)
{
    header("Location: " . $location);
    exit;
}

function confirm_result($result)
{
    if (!$result) {
        die("Databse query failed");
    }
}

function get_pages_for_subject($subject_id, $public = true)
{
    global $connection;

    $query = "SELECT * FROM pages WHERE subject_id={$subject_id} ";
    if ($public) {
        $query .= " AND visible=1 ";
    }
    $query .=  "ORDER BY position ASC";
    $result =  $connection->query($query);
    confirm_result($result);
    return $result;
}

function get_default_page($subject_id)
{
    $page = get_pages_for_subject($subject_id);
    if ($first_page = $page->fetch_assoc()) {
        return $first_page;
    } else {
        return null;
    }
}

function get_selected_page($public = true)
{
    global $current_subject;
    global $current_page;

    if (isset($_GET["subject"])) {
        $current_subject  =  get_subject_by_id($_GET["subject"]);
        if ($current_subject && $public) {
            $current_page = get_default_page($current_subject["id"]);
        } else {
            $current_page = null;
        }
    } elseif (isset($_GET["page"])) {
        $current_subject = null;
        $current_page = get_page_by_id($_GET["page"]);
    } else {
        $current_subject = null;
        $current_page = null;
    }
}

function get_subject_by_id($id)
{
    global $connection;
    $query = "SELECT * FROM subjects WHERE id={$id} LIMIT 1";
    $result  = $connection->query($query);
    confirm_result($result);
    if ($subject = $result->fetch_assoc()) {
        return $subject;
    } else {
        return null;
    }
}

function get_page_by_id($id,$public=true)
{
    global $connection;
    $query = "SELECT * FROM pages WHERE id={$id} ";
    if($public){
        $query .= " AND visible = 1 ";
    }
    $query.= "LIMIT 1";
    $result = $connection->query($query);
    confirm_result($result);
    if ($page = $result->fetch_assoc()) {
        return $page;
    } else {
        return null;
    }
}

function get_subjects($public = true)
{
    global $connection;
    $query = "SELECT * FROM subjects ";
    if ($public) {
        $query .= "WHERE visible = 1 ";
    }
    $query .= "ORDER BY position ASC";

    $result = $connection->query($query);
    confirm_result($result);
    return $result;
}

function get_pages($subject_id)
{
    global $connection;
    $query =  "SELECT * FROM pages WHERE subject_id={$subject_id} ";
    $query .= "ORDER BY position ASC";
    $pages = $connection->query($query);
    confirm_result($pages);
    return $pages;
}

function create_nav($current_subject, $current_page)
{
    $subjects =  get_subjects(false);
    if ($subjects->num_rows > 0) {
        $output = "<ul class=\"subjects\">";
        while ($subject = $subjects->fetch_assoc()) {
            $output .= "<li ";
            if ($current_subject && $current_subject["id"] == $subject["id"]) {
                $output .= "class=\"active\" ";
            }
            $output .= ">";

            $output .= "<a href=\"manage_content.php?subject=";
            $output .= urlencode($subject["id"]);
            $output .= "\">";

            $output .= htmlentities($subject["menu_name"]);

            $output .= "</a> ";
            $pages =  get_pages($subject["id"]);
            if ($pages->num_rows > 0) {
                $output .= "<ul class=\"pages\">";
                while ($page = $pages->fetch_assoc()) {
                    $output .= "<li ";
                    if ($current_page && $current_page["id"] == $page["id"]) {
                        $output .= "class=\"active\" ";
                    }
                    $output .= ">";

                    $output .= "<a href=\"manage_content.php?page=";
                    $output .= urlencode($page["id"]);
                    $output .= "\">";

                    $output .= htmlentities($page["menu_name"]);
                    $output .= "</a></li>";
                }
                $output .= "</ul>";
            }
            $output .= "</li>";
        }
        $output .= "</ul>";
        echo  $output;
    }
}

function create_public_nav($current_subject, $current_page)
{
    $subjects =  get_subjects();
    if ($subjects->num_rows > 0) {
        $output = "<ul class=\"subjects\">";
        while ($subject = $subjects->fetch_assoc()) {
            $output .= "<li ";
            if ($current_subject && $current_subject["id"] == $subject["id"]) {
                $output .= "class=\"active\" ";
            }
            $output .= ">";

            $output .= "<a href=\"index.php?subject=";
            $output .= urlencode($subject["id"]);
            $output .= "\">";

            $output .= htmlentities($subject["menu_name"]);

            $output .= "</a> ";
            $pages =  get_pages($subject["id"]);
            if ($pages->num_rows > 0) {
                $output .= "<ul class=\"pages\">";
                while ($page = $pages->fetch_assoc()) {
                    $output .= "<li ";
                    if ($current_page && $current_page["id"] == $page["id"]) {
                        $output .= "class=\"active\" ";
                    }
                    $output .= ">";

                    $output .= "<a href=\"index.php?page=";
                    $output .= urlencode($page["id"]);
                    $output .= "\">";

                    $output .= htmlentities($page["menu_name"]);
                    $output .= "</a></li>";
                }
                $output .= "</ul>";
            }
            $output .= "</li>";
        }
        $output .= "</ul>";
        echo  $output;
    }
}


function get_admin_by_username($username)
{
    global $connection;

    $query = "SELECT * FROM admins WHERE username=\"{$username}\" LIMIT 1";
    $result = $connection->query($query);
    confirm_result($result);
    if ($admin =  $result->fetch_assoc()) {
        return $admin;
    } else {
        return null;
    }
}

function check_password($password, $hash_password)
{
    $hash = crypt($password, $hash_password);
    if ($hash === $hash_password) {
        return true;
    }
    return false;
}

function login($username, $password)
{
    $admin = get_admin_by_username($username);
    if ($admin) {
        if (check_password($password, $admin["hashed_password"])) {
            return $admin;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function check_logged_in()
{
    if (!isset($_SESSION["admin_id"])) {
        redirect("login.php");
    }
}


function password_encrypt($password)
{
    $hash_format = "$2y$10$";   
    $salt_length = 22;                    
    $salt = generate_salt($salt_length);
    $format_and_salt = $hash_format . $salt;
    $hash = crypt($password, $format_and_salt);
    return $hash;
}

function generate_salt($length)
{

    $unique_random_string = md5(uniqid(mt_rand(), true));
    $base64_string = base64_encode($unique_random_string);
    $modified_base64_string = str_replace('+', '.', $base64_string);
    $salt = substr($modified_base64_string, 0, $length);
    return $salt;
}

function get_admins(){
    global $connection;
    $query = "SELECT * FROM admins ORDER BY id ASC";
    $result = $connection->query($query);
    confirm_result($result);
    return $result;
}

function get_admin_by_id($id){
    global $connection;

    $query = "SELECT * FROM admins WHERE ";
    $query .= "id = {$id} ";
    $query .= "LIMIT 1";

    $result = $connection->query(($query));
    confirm_result($result);

    if($admin = $result->fetch_assoc()){
        return $admin;
    }else{
        return null;
    }
}
