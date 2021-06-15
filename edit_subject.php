<?php
require_once("./include/session.php");
require_once("./include/connection.php");
require_once("./include/functions.php");
?>

<?php $mode_admin= true;?>
<?php require_once("./include/header.php"); ?>

<?php check_logged_in();?>

<?php get_selected_page(); ?>

<?php

if(isset($_POST["submit"])){
    
    $id = $current_subject["id"];
    $menu_name = $_POST["menuname"];
    $position = (int) $_POST["position"];
    $visible = (int) $_POST["visible"];

    $query = "UPDATE subjects SET ";
    $query .= "menu_name = '{$menu_name}', ";
    $query .= "position = {$position}, ";
    $query .= "visible = {$visible} ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";

    $result = $connection->query($query);

    if($result){
        redirect("manage_content.php");

    }else{

    }

}

?>

<div class="row h-90">
    <div class="col-nav h-100">
        <?php create_nav($current_subject,$current_page)?>
    </div>
    <div class="col-right h-100">
        <h2 class="mb-15">Edit Subject: <?php echo $current_subject["menu_name"] ?></h2>
        <form class="mb-15" action="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]);?>" method="post">
            <div class="mb-15">
                <label>Menu name:</label>
                <input name="menuname" type="text" <?php echo "value=\"{$current_subject["menu_name"]}\""; ?> >
            </div>
            <div class="mb-15">
                <label>Position:</label>
                <?php 
                $subjects =  get_subjects(false);
                $subject_count = mysqli_num_rows($subjects);
                echo "<input name=\"position\" type=\"number\" min=\"1\" max=\"{$subject_count}\"  value=\"{$current_subject["position"]}\"> ";
                ?>
            </div>
            <div class="mb-15">
                <label>Visible</label>
                <input type="radio" name="visible" value="0"  <?php if ($current_subject["visible"] == 0) { echo "checked"; } ?>>
                <label>No</label>
                <input type="radio" name="visible" value="1"  <?php if ($current_subject["visible"] == 1) { echo "checked"; } ?>>
                <label>Yes</label>
            </div>
            <div>
                <input name="submit" type="submit" value="Edit Subject">
            </div>
        </form>
        <a href="manage_content.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Cancel</a>
        <a href="delete_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Delete subject</a>
    </div>
</div>

<?php require_once("./include/footer.php"); ?>