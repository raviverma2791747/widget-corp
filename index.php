<?php require_once("./include/connection.php") ?>
<?php require_once("./include/session.php") ?>
<?php require_once("./include/functions.php") ?>

<?php $mode_admin= false;?>
<?php require_once("./include/header.php") ?>

<?php get_selected_page()?>
<div id="main" class="row h-90">
    <div class="col-nav h-100">
        <?php create_public_nav($current_subject,$current_page) ?>
    </div>
    <div id="page" class="col-right h-100">

    <?php
    if($current_page){
       echo "<h2>".$current_page["menu_name"]."</h2><br>";
       echo "<p>".htmlentities($current_page["content"])."</p>";
    }else{
        echo "<p>Welcome!</p";
    }
 ?>

    </div>
</div>


<?php require_once("./include/footer.php") ?>