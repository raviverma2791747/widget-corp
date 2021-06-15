<?php require_once("./include/session.php")?>
<?php require_once("./include/functions.php")?>

<?php $mode_admin= true;?>
<?php require_once("./include/header.php") ?>
<?php check_logged_in()?>

<div class="row h-90">
    <div class="col-nav h-100">
        
    </div>
    <div class="col-right h-100">
        <h2 class="mb-15">Admin Menu</h2>
        <p class="mb-15">Welcome to the amdin area, admin.</p>
        <ul>
            <li><a href="manage_content.php">Manage Website Content</a></li>
            <li><a href="manage_admins.php">Manage Admin Users</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>

<?php require_once("./include/footer.php") ?>