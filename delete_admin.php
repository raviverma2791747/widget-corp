<?php require_once("./include/session.php"); ?>
<?php require_once("./include/connection.php"); ?>
<?php require_once("./include/functions.php"); ?>
<?php check_logged_in(); ?>


<?php
 
 $admin = get_admin_by_id($_GET["id"]);
 if(!$admin) {
     redirect("manage_admins.php");
 }

 $id= $admin["id"];
 $query = "DELETE FROM admins WHERE id = {$id} LIMIT 1";

 $result = $connection->query($query);

 if($result && $connection->affected_rows == 1){
    redirect("manage_admins.php");
 }else{
     echo "<script>alert(\"Admin deletion failed!\")</script>";
     redirect("manage_admin.php");
 }
?>