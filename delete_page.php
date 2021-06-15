<?php require_once("./include/session.php") ?>
<?php require_once("./include/connection.php") ?>
<?php require_once("./include/functions.php") ?>

<?php check_logged_in(); ?>
<?php 

$current_page = get_page_by_id($_GET["page"],false);

if(!$current_page){
    redirect("manage_content.php");
}

$id = $current_page["id"];
$query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
$result = $connection->query($query);

if($result && $connection->affected_rows ==1){
    redirect("manage_content.php");
}else {
    redirect("manage_content.php?page={$id}");
}

?>