<?php
require_once("./include/session.php");
require_once("./include/connection.php");
require_once("./include/functions.php");
?>

<?php $mode_admin= true;?>
<?php require_once("./include/header.php");?>

<?php 
if(isset($_POST["submit"])){

    $username = $_POST["username"];
    $password = $_POST["password"];

    if( empty($username) ||  empty($password) ){
        echo "<script>alert(\"Username or password is empty\")</script>";
    }else{

        $hashed_password = password_encrypt($password);
        $query = "INSERT INTO admins ( ";
        $query .= " username, hashed_password ";
        $query .= ") VALUES ( ";
        $query .= " '{$username}' , '{$hashed_password}' ";
        $query .= "); ";
        $result = $connection->query($query);
        
        if($result){
            redirect("manage_admins.php");
        }else{
            echo "<script>alert(\"Admin creation failed\")</script>";
        }
    }
}
?>
<div class="row h-90">
    <div class="col-nav h-100">

    </div>
    <div class="col-right h-100">
       <h2 class="mb-15">Create Admin</h2>
       <form class="mb-15" action="new_admin.php" method="post">
           <div class="mb-15">
               <label>Username: </label>
               <input name="username" type="text">
           </div>
           <div class="mb-15">
               <label>Password: </label>
               <input name="password" type="password">
           </div>
           <div>
               <input type="submit" name="submit" value="Create Admin">
           </div>
       </form>
       <a href="manage_admins.php">Cancel</a>
    </div>
</div>

<?php require_once("./include/footer.php");?>