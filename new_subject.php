<?php
require_once("./include/session.php");
require_once("./include/connection.php");
require_once("./include/functions.php");
?>

<?php $mode_admin= true;?>
<?php require_once("./include/header.php"); ?>

<?php check_logged_in();?>

<?php  get_selected_page()?>
<?php

if(isset($_POST["submit"])){
    
    $menu_name = $_POST["menuname"];
    $position = (int) $_POST["position"];
    $visible = (int) $_POST["visible"];


    $query = "INSERT INTO subjects ( ";
    $query .= "menu_name, position, visible ";
    $query .= ") VALUES ( ";
    $query .= " '{$menu_name}' , {$position} , {$visible} ";
    $query .= "); ";

    $result = $connection->query($query);

    if($result){
        redirect("manage_content.php");

    }else{

    }

}

?>

<div class="row h-90">
    <div class="col-nav h-100">
        <?php create_nav($current_subject, $current_page);?>
    </div>
    <div class="col-right h-100">
        <h2 class="mb-15">Create Subject</h2>
        <form class="mb-15" action="new_subject.php?" method="post">
            <div class="mb-15">
                <label>Menu name:</label>
                <input name="menuname" type="text">
            </div>
            <div class="mb-15">
                <label>Position:</label>
                <?php 
                $subjects =  get_subjects(false);
                $subject_count = mysqli_num_rows($subjects)+1;
                echo "<input name=\"position\" type=\"number\" min=\"1\" max=\"{$subject_count}\" > ";
                ?>
            </div>
            <div class="mb-15">
                <label>Visible</label>
                <input type="radio" name="visible" value="0">
                <label>No</label>
                <input type="radio" name="visible" value="1">
                <label>Yes</label>
            </div>
            <div>
                <input name="submit" type="submit" value="Create Subject">
            </div>
        </form>
        <a href="manage_content.php">Cancel</a>
    </div>
</div>

<?php require_once("./include/footer.php"); ?>