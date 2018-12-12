<?php include 'header.php';?>
<?php include 'user.php';?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Personal Page R&M Marktplaats</title>
    <form action="personal.php" method="POST" id=search>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <input type="text" name="zoekbalk" placeholder="zoeken"><br/>
    <input name="zoek" type="submit" value="zoeken">
</form>
</head>
<body>


    <?php
    require_once("nbbc.php");
    $bbcode = new BBCode;

   // Als je niet ingelogd bent wordt je naar login.php gestuurd.
   if(!isset($_SESSION['username'])) {
    //true al ingelogd
    header("location:login.php");
        } else{

            if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                //true al ingelogd
                if(mysqli_num_rows($res) >0) {
                    while($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $username = $row['username'];
                        $email = $row['email'];
                        $date = $row['date_formatted'];
                        $post = "<div><p><h1>$username</h1><b>Email:&nbsp$email<br/>Aangemeld sinds:<br/>$date<p></div><p>Geplaatste artikel(en):</b>";
                        echo $post;
                    }
                }
            }
        }






?>
</div>
</body>
<?php include 'footer.php';?>
</html>