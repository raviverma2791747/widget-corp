<?php require_once("./include/session.php") ?>
<?php require_once("./include/connection.php") ?>
<?php require_once("./include/functions.php") ?>

<?php check_logged_in(); ?>
<?php 

$current_subject = get_subject_by_id($_GET["subject"],false);

if(!$current_subject){
    redirect("manage_content.php");
}


$pages =  get_pages_for_subject($current_subject["id"],false);
if($pages->num_rows > 0 ){
    redirect("manage_content.php?=subect={$current_subject["id"]}");

}

$id = $current_subject["id"];
$query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
$result = $connection->query($query);

if($result && $result->affected_rows ==1){
    redirect("manage_content.php");
}else{
    redirect("manage_content.php?=subect={$id}");
}

?>