<?php
    $x = 0;
  if(isset($_POST['cats'])) {
    $x = $_POST['cats'];
  }
  if(isset($_POST['reset'])) {
    $sql = "SELECT * FROM articles ORDER BY id DESC";
  }

        require_once("nbbc.php");
        $bbcode = new BBCode;
 
    //$pid=$_SESSION['pid'];
    // Als je niet ingelogd bent wordt je naar login.php gestuurd.
    //echo $_SESSION['username']; 
    if(!isset($_SESSION['username'])) {
        //niet ingelogd 
        header("location:login.php");
    } else {
        // zodat de value (om de waarde te behouden na foutmelding) in form niet als tekst wordt geprint.
        
        // Invoeren van tekst en titel voor de blog in tabel comments.
        if(isset($_POST['offers'])) {
        $comment = strip_tags($_POST['comment']);
        $offer = strip_tags($_POST['offer']);
        $author = $_SESSION['username'];
        $art_id = $pid;
        $captcha = strip_tags($_POST['captcha']); 
        $code = $_POST['cap'];
        $rick = isset($_POST['anonymous']);
        //echo $rick;
        if($rick == "") {
            $author;
        }   else {
            $author = "anonymous";
        }
        $sql =  "INSERT into offers (comment, offer, author, art_id) VALUES ('$comment','$offer', '$author', '$art_id')";
        if(empty($comment) || empty($author) || $captcha != $code || empty($captcha)) {
        echo "De post is niet compleet ingevuld!";
        
        } else {
        
        if (mysqli_query($db, $sql));
        //echo "GELUKT";
        //exit();
        //header("Location: index.php?pid=$pid");
        }
        }
    }     

$sql = "SELECT *, DATE_FORMAT(date, '%D %M %Y om %H:%i') as date_formatted FROM offers WHERE art_id = $pid ORDER BY date DESC";       
$res = mysqli_query($db, $sql) or die(mysqli_error($db));
$post ="";
// Geeft alleen mogelijkheid to wijzigen en verwijderen als ingelog bent.   
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    //true al ingelogd
    if(mysqli_num_rows($res) >0) {
        while($row = mysqli_fetch_assoc($res)) {
           // $id = $row['id'];
            $com_id = $row['com_id']; 
            $offer = $row['offer'];
            $comment = $row['comment'];
            $author = $row['author'];
            $art_id = $row['art_id'];
            $date = $row['date_formatted'];
            //$admin = "<div><a href='del_comment.php?com_id=$com_id&pid=$pid'>Verwijder bod</a></div>";
            $output = $bbcode->Parse($content);
            $post = "<div><br/>$comment<p><b>$author&nbspBedrag:&nbsp€&nbsp$offer</b>&nbsp&nbsp&nbsp$date&nbsp&nbsp<p></div>";
            
            echo $post;
       
            }
    } else { 
            echo "Er zijn geen biedingen in deze aanbod.";
    }
} else if(mysqli_num_rows($res) >0) {
    while($row = mysqli_fetch_assoc($res)) {
        $id = $row['id'];
        $title = $row['title'];
        $content = $row['content'];
        $date = $row['date_formatted'];
        $output = $bbcode->Parse($content);
        $post = "<div><a href='index.php?pid=$id'/><b>$title<?b></a>&nbsp&nbsp&nbsp<b>$date</b><p><br/></div>";
        echo $post;
    } 
}
?>
<!DOCTYPE html>
<html>
<head>
</head>

<body>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
       
        <br/><br/>
        <textarea placeholder="Comment" name="comment" rows="20" cols="50"></textarea><br/><br/>
        
        <div class="input-icon">
        <input type="number" step="0.01" name="offer" >
        <i>€</i>
        </div>
        <br/>
        <input name="offers" type="submit" value="Post">
        <input name="reset" type="reset" value="Reset">
        <input type="button" value="Terug" onclick="location.href='index.php';"><br/><br/>
        <!-- text only anonymous? 
        <input type="checkbox"  class="anonymous" name="anonymous" value="0"/> --> 
        <?php echo $cap = (rand(100,1000)); ?>
        <input placeholder="Wat is de code?" type="text" name="captcha">
        <input type="hidden" name="cap" value="<?php echo $cap;?>">
    </form>
    
</body>    
</html>