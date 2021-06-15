<?php
require_once("./include/session.php");
require_once("./include/connection.php");
require_once("./include/functions.php");
?>

<?php $mode_admin= true;?>
<?php require_once("./include/header.php"); ?>

<?php check_logged_in();?>


<?php get_selected_page();?>

<?php 
if(!$current_subject){
  redirect("manage_content.php");
}
?>

<?php

if(isset($_POST["submit"])){
    
    $subject_id = $current_subject["id"];
    $menu_name = $_POST["menuname"];
    $position = (int) $_POST["position"];
    $visible = (int) $_POST["visible"];
    $content = $_POST["content"];



    $query = "INSERT INTO pages( ";
    $query .= "subject_id, menu_name, position, visible, content ";
    $query .= ") VALUES ( ";
    $query .= " {$subject_id} , '{$menu_name}' , {$position} , {$visible} , '{$content}' ";
    $query .= "); ";

    $result = $connection->query($query);

    if($result){
        redirect("manage_content.php?subject=".urlencode($current_subject["id"]));

    }else{
    }

}

?>

<div class="row h-90">
    <div class="col-nav h-100">
<?php create_nav($current_subject,$current_page); ?>
    </div>
    <div class="col-right h-100">
        <h2 class="mb-15">Create Page</h2>
        <form class="mb-15" action="new_page.php?subject=<?php echo urlencode($current_subject["id"]);?>" method="post">
            <div class="mb-15">
                <label>Menu name:</label>
                <input name="menuname" type="text">
            </div>
            <div class="mb-15">
                <label>Position:</label>
                <?php 
                $pages =  get_pages_for_subject($current_subject["id"]);
                $page_count = mysqli_num_rows($pages)+1;
                echo "<input name=\"position\" type=\"number\" min=\"1\" max=\"{$page_count}\" > ";
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
                <label>Content: </label><br>
                <textarea name="content" rows="20" cols="80"></textarea>
            </div>
            <div>
                <input name="submit" type="submit" value="Create Page">
            </div>
        </form>
        <a href="manage_content.php?subject=<?php echo urlencode($current_subject["id"]);?>">Cancel</a>
    </div>
</div>

<?php require_once("./include/footer.php"); ?>