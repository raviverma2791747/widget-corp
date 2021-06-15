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
if(!$current_page){
  redirect("manage_content.php");
}
?>

<?php

if(isset($_POST["submit"])){
    
    $id = $current_page["id"];
    $menu_name = $_POST["menuname"];
    $position = (int) $_POST["position"];
    $visible = (int) $_POST["visible"];
    $content = $_POST["content"];



    $query = "UPDATE pages SET ";
    $query .= "menu_name = '{$menu_name}', ";
    $query .= "position = {$position}, ";
    $query .= "visible = {$visible}, ";
    $query .= "content = '{$content}' ";
    $query .= "WHERE id={$id} ";
    $query .= "LIMIT 1";

    $result = $connection->query($query);

    if($result){
        redirect("manage_content.php?page=".urlencode($current_page["id"]));
    }else{
      
    }

}

?>

<div class="row h-90">
    <div class="col-nav h-100">
        <?php create_nav($current_subject,$current_subject) ?>
    </div>
    <div class="col-right h-100">
        <h2 class="mb-15">Edit Page : <?php echo $current_page["menu_name"] ?></h2>
        <form class="mb-15" action="edit_page.php?page=<?php echo urlencode($current_page["id"]);?>" method="post">
            <div class="mb-15">
                <label>Menu name:</label>
                <input name="menuname" type="text" <?php echo "value=\"{$current_page["menu_name"]}\""?>>
            </div>
            <div class="mb-15">
                <label>Position:</label>
                <?php 
                $pages =  get_pages_for_subject($current_page["subject_id"]);
                $page_count = mysqli_num_rows($pages);
                echo "<input name=\"position\" type=\"number\" min=\"1\" max=\"{$page_count}\" value=\"{$current_page["position"]}\"> ";
                ?>
            </div>
            <div class="mb-15">
                <label>Visible</label>
                <input type="radio" name="visible" value="0" <?php if ($current_page["visible"] == 0) { echo "checked"; } ?>>
                <label>No</label>
                <input type="radio" name="visible" value="1" <?php if ($current_page["visible"] == 1) { echo "checked"; } ?>>
                <label>Yes</label>
            </div>
            <div>
                <label>Content: </label><br>
                <textarea name="content" rows="20" cols="80"><?php echo $current_page["content"]?></textarea>
            </div>
            <div>
                <input name="submit" type="submit" value="Edit Page">
            </div>
        </form>
        <a href="manage_content.php?page=<?php echo urlencode($current_page["id"])?>">Cancel</a>
        <a href="delete_page.php?page=<?php echo  urlencode($current_page["id"]);?>">Delete Page</a>
    </div>
</div>

<?php require_once("./include/footer.php"); ?>