<?php
require_once("./include/session.php");
require_once("./include/connection.php");
require_once("./include/functions.php");
?>

<?php $mode_admin= true;?>
<?php require_once("./include/header.php"); ?>

<?php check_logged_in() ?>

<?php

$admin = get_admin_by_id($_GET["id"]);
if (!$admin) {
    redirect("manage_admins.php");
}

?>
<?php
if (isset($_POST["submit"])) {
    $id = $admin["id"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) ||  empty($password)) {
        echo "<script>alert(\"Username or password is empty\")</script>";
    } else {

        $hashed_password = password_encrypt($password);
        echo $hashed_password;
        $query = "UPDATE admins set  ";
        $query .= " username = '{$username}' , ";
        $query .= " hashed_password = '{$hashed_password}' ";
        $query .= "WHERE id = {$id} ";
        $query .= "LIMIT 1";
        $result = $connection->query($query);

        if ($result) {
            redirect("manage_admins.php");
        } else {
            echo "<script>alert(\"Admin Edit failed\")</script>";
        }
    }
}
?>
<div class="row h-90">
    <div class="col-nav h-100">
    </div>
    <div class="col-right h-100">
        <h2 class="mb-15">Edit Admin: <?php echo $admin["username"]; ?></h2>
        <form class="mb-15" action="edit_admin.php?id=<?php echo $admin["id"]; ?>" method="post">
            <div class="mb-15">
                <label>Username: </label>
                <input name="username" type="text" value="<?php echo $admin["username"]; ?>">
            </div>
            <div class="mb-15">
                <label>Password: </label>
                <input name="password" type="password">
            </div>
            <div>
                <input type="submit" name="submit" value="Edit Admin">
            </div>
        </form>
        <a href="manage_admins.php">Cancel</a>
    </div>
</div>

<?php require_once("./include/footer.php"); ?>