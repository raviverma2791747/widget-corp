<?php require_once("./include/session.php"); ?>
<?php require_once("./include/connection.php"); ?>
<?php require_once("./include/functions.php"); ?>

<?php check_logged_in(); ?>

<?php $mode_admin= true;?>
<?php require_once("./include/header.php"); ?>

<?php get_selected_page(false)?>
<div class="row h-90">
    <div class="col-nav h-100">
        <ul>
            <li><a  href="admin.php">&laquo; Main Menu</a></li>
        </ul>
        <?php create_nav($current_subject,$current_page); ?>

        <ul>
            <li><a  href="new_subject.php">+ Add a subject</a></li>
        </ul>
    </div>
    <div class="col-right h-100">
        <?php 
          if($current_page){
              echo "<h2 class=\"mb-15\">Manage Page</h2>";
              echo "<div>Menu name: ". $current_page["menu_name"]."</div>";
              echo "<div>Position: ".$current_page["position"]."</div>";
              echo "<div>Visible: ";
              if($current_page["visible"]){
                  echo "yes";
              }else{
                  echo "no";
              }
              echo "</div>";
              echo "<div class=\"mb-15\">Content: </div>";
              echo "<p class=\"d-inline-block border mb-15\">".$current_page["content"]."</p><br>";
              echo "<a href=\"edit_page.php?page={$current_page["id"]}\">Edit page</a>";
          }else if($current_subject){
            echo "<h2 class=\"mb-15\">Manage Subject</h2>";
            echo "<div>Menu name: ".$current_subject["menu_name"]."</div>";
            echo "<div>Position: ".$current_subject["position"]."</div>";
            echo "<div>Visible: ";
            if($current_subject["visible"]){
                echo "yes";
            }else{
                echo "no";
            }
            echo "</div>";
            echo "<a  href=\"edit_subject.php?subject={$current_subject["id"]}\">Edit subject</a>";
            echo "<hr>";

            $pages = get_pages_for_subject($current_subject["id"]);

            echo "<h2 class=\"mb-15\">Pages in this subject:</h2>";

            echo "<ul class=\"mb-15\">";

            while($page = $pages->fetch_assoc()){
                echo "<li><a href=\"manage_content.php?page={$page["id"]}\">".$page["menu_name"]."</a></li>";
            }
            echo "</ul>";

            echo "<a href=\"new_page.php?subject=".urlencode($current_subject["id"])."\">+ Add a new page to this subject</a>";
              
          }else{
              echo "Please select a subject or page.";
          }
        ?>
    </div>
</div>


<?php require_once("./include/footer.php"); ?>