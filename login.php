<?php require_once("./include/session.php") ?>
<?php require_once("./include/connection.php") ?>
<?php require_once("./include/functions.php") ?>


<?php $mode_admin= false;?>
<?php require_once("./include/header.php") ?>

<?php


if (isset($_POST["submit"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $admin = login($username, $password);

    if ($admin) {
        $_SESSION["admin_id"] = $admin["id"];
        $_SESSION["username"] = $admin["username"];
        redirect("admin.php");
    } else {

    }
} else {
    if (isset($_SESSION["admin_id"]) && isset($_SESSION["username"])) {
        redirect("admin.php");
    }
}

?>
<div class="row h-90">
    <div class="col-nav h-100">

    </div>
    <div class="col-right h-100">
        <h2 class="mb-15">Login</h2>
        <form action="login.php" method="post">
            <div class="mb-15">
                <label>Username:</label>
                <input name="username" type="text">
            </div>
            <div class="mb-15">
                <label>Password:</label>
                <input name="password" type="password">
            </div>
            <div>
                <input name="submit" type="submit">
            </div>
        </form>
    </div>
</div>
<?php require_once("./include/footer.php"); ?>