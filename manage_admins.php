<?php
require_once("./include/session.php");
require_once("./include/connection.php");
require_once("./include/functions.php");
?>


<?php check_logged_in();?>
<?php $mode_admin= true;?>
<?php require_once("./include/header.php"); ?>


<div class="row h-90">
    <div class="col-nav h-100">
    <ul>
            <li><a  href="admin.php">&laquo; Main Menu</a></li>
        </ul>
    </div>
    <div class="col-right h-100">
        <h2>Manage Admins</h2>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $admins = get_admins();
                while($admin = $admins->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>";
                    echo $admin["username"];
                    echo "</td>";
                    echo "<td>";
                    echo "<a href=\"edit_admin.php?id={$admin["id"]}\">Edit</a>";
                    echo "<a href=\"delete_admin.php?id={$admin["id"]}\">Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="new_admin.php">Add new admin</a>
    </div>
</div>




<?php require_once("./include/footer.php"); ?>