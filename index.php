<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname= "login";
$conn= mysqli_connect($hostname, $username, $password, $dbname);
if(!$conn){
    die("Nu s-a putut conecta la baza de date!");
}

if($_POST){
    $uname = $_POST["username"];
    $pass = $_POST["password"];
    //Metoda prin care ne asiguram ca SQL Injection nu functioneaza
    $uname = mysqli_real_escape_string($conn, $uname);//test' or 1=1#
    $pass = mysqli_real_escape_string($conn, $pass);//functia indeparteaza spatiile, ', ramanand doar textul introdus
    
    $que = "SELECT username FROM users WHERE username = '$uname'";
    $next=mysqli_query($conn,$que);


    if($next){
        $num = mysqli_num_rows($next);
        if($num>0){
            $query = "SELECT password FROM users WHERE username='$uname'";

            $rezultat = mysqli_query($conn, $query);

            $row = mysqli_fetch_assoc($rezultat);
            $hash = implode("",$row);

            //echo  "$hash";
            //echo nl2br ("\n$pass\n");

            //$verify=password_verify($pass, $hash);
            //echo nl2br ("\n verify is".is_bool($verify));
            //echo"password_verify($pass, $hash)";

            //$new = password_hash($pass, PASSWORD_DEFAULT);
            //echo "$new";

            if(password_verify($pass, $hash)){
                //echo nl2br("\n a intrat \n");             
                echo "Welcome $uname!";
            } else {
                echo nl2br("\nParola gresita!");//Wrong password
            }
        }else{
            echo nl2br("\nUsername gresit");//Wrong username
        }
        
    }    
    
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href= "style.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Login</title>
</head>

<body>
   
  <!--  <form action method="POST" autocomplete = "off" >
        <input type="text" name="username" placeholder="Username"/><br>
        <input type="pasw" name="password" placeholder="********"/><br>
        <input type="submit" name="login" value="Login"/>
    </form> -->
   

    <div class="wrapper fadeInDown">

        <div id="formContent">
            <!-- Tabs Titles -->
            
            <!-- Login Form -->
            <div class="login-form">
                <h2>Login</h2>
                <form action method="POST" autocomplete = "off" >
                    <input type="text" id="login" class="fadeIn second" name="username" placeholder="Username">
                    <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password">
                    <input type="submit" class="fadeIn fourth" name="login" value="Log In">
                </form>
            </div>
            <div>
                <a href="sign-up.php">For sign up click here</a>
            </div>            
            
        </div>

        

    </div>

</body>

</html>