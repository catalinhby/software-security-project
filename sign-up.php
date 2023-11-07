<?php
$success=0;
$user=0;
$invalid=0;

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
    $mail =$_POST["email"];
    $cpass =$_POST["repass"];
    //Metoda prin care ne asiguram ca SQL Injection nu functioneaza
    $uname = mysqli_real_escape_string($conn, $uname);//test' or 1=1#
    $pass = mysqli_real_escape_string($conn, $pass);//functia indeparteaza spatiile, ', ramanand doar textul introdus

    $sql= "SELECT * FROM users WHERE username = '$uname'";
    //query-ul transmis ar fi aratat asa "SELECT * FROM users WHERE username = 'test' or 1=1#';
    //si ar fi permis unui atacator sa se logheze pe site fara a introduce o parola valida
    $result = mysqli_query($conn, $sql);

    if($result){
        $num=mysqli_num_rows($result);
        if($num>0){
            $user=1;
            echo "Exista deja un utilizator cu aceste date";
        }else{
            if($pass===$cpass){
                $hash = crypt($pass, '$6$rounds=555000$acestsirestefolositcasare$'); //algoritmul de criptare este sha-512
                $usercrypt=crypt($uname, '$6$rounds=555000$acestsirestefolositcasare$');
                $mailcrypt=crypt($mail, '$6$rounds=555000$acestsirestefolositcasare$');
                $sql="insert into users(username, password, email) values('$usercrypt','$hash','$mailcrypt')";
                $result=mysqli_query($conn, $sql);
                if($result){
                    $success=1;
                    header('location:index.php');
                }
                }else{
                    $invalid=1;
                }
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
            
            <!-- sign up Form -->
            
            <div class="sign-up-form">
                <h2>Sign Up</h2>
                <form action method="POST" autocomplete = "off" >
                    <input type="text" id="username" class="fadeIn second" name="username" placeholder="Username">
                    <input type="text" id="email" class="fadeIn second" name="email" placeholder="Email">
                    <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password">
                    <input type="password" id="repass" class="fadeIn third" name="repass" placeholder="Confirm password">
                    <input type="submit" class="fadeIn fourth" name="login" value="Sign up"><br>
                    <a href="index.php">For login click here</a>
                </form>
            </div>
            
        </div>

        

    </div>

</body>

</html>