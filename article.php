<?php
    $x = 0;
  if(isset($_POST['cats'])) {
    $x = $_POST['cats'];
  }
  if(isset($_POST['reset'])) {
    $sql = "SELECT * FROM articles ORDER BY id DESC";
  }
?>

<?php
    require_once("nbbc.php");
    $bbcode = new BBCode; 
    
    if($x <= 1) {
        $sql = "SELECT *, DATE_FORMAT(date, '%D %M %Y om %H:%i') as date_formatted FROM articles ORDER BY date DESC";
    } else {
        $sql = "SELECT *, DATE_FORMAT(date, '%D %M %Y om %H:%i') as date_formatted FROM articles WHERE cat_id='$x' ORDER BY date DESC";       
    }
    $res = mysqli_query($db, $sql) or die(mysqli_error($db));
    $post ="";
    // Geeft alleen mogelijkheid to wijzigen en verwijderen als ingelog bent.   
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        //true al ingelogd
        if(mysqli_num_rows($res) >0) {
            while($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $title = $row['title'];
                $username = $_SESSION['username'];
                $content = $row['content'];
                $author = $row['author'];
                $cats = $row['cat_id'];
                $date = $row['date_formatted'];
                $admin = "<div><a href='del_post.php?pid=$id'>Verwijder</a>&nbsp;<a href='edit_post.php?pid=$id'>Wijzig</a>&nbsp</div>";
                $output = $bbcode->Parse($content);
                
                if ($author==$username) {
                    $post = "<div><a href='index.php?pid=$id'/>$title</a>&nbsp<b>Wie:</b>&nbsp$author&nbsp<b>Categorie:</b>&nbsp$cats&nbsp<b>op:&nbsp</b>$date&nbsp<p></div>";
                    echo $post;
                } else {
                    $post = "<div><a href='index.php?pid=$id'/>$title</a>&nbsp<b>Wie:</b>&nbsp$author&nbsp<b>Categorie:</b>&nbsp$cats&nbsp<b>op:&nbsp</b>$date&nbsp<p></div>";
                    echo $post;
                }
        }
        } else { 
                echo "Er zijn geen berichten uit die categorie.";
        }
    } else if(mysqli_num_rows($res) >0) {
        while($row = mysqli_fetch_assoc($res)) {
            $id = $row['id'];
            $title = $row['title'];
            $content = $row['content'];
            $author = $row['author'];
            $date = $row['date_formatted'];
            $output = $bbcode->Parse($content);
            $post = "<div><a href='index.php?pid=$id'/>$title</a>&nbsp<b>Wie:</b>&nbsp$author&nbsp<b>op:&nbsp</b>$date&nbsp<p></div>";
            echo $post;
        } 
    }
?>
  
<script>
    $(function() {
    var fixed = document.getElementById('blog'), overflow;
    $(window).on('load resize', function() {
    overflow = fixed.scrollHeight-$('#fixed').height();
    });
    fixed.on('touchmove', function() {
    if (overflow) return true;
    else return false;
    });
</script>