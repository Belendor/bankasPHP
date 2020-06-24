<?php

session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /bankas/login.php');
    die();
}

if (isset($_SESSION['login'])) {
    header('Location: /bankas/saskaitu-sarasas.php');
    die();
}


if(!empty($_POST)){

    $data = json_decode(file_get_contents(__DIR__ .'/admin.json'),1);

        foreach($data as $arr){

            if($_POST['name'] == $arr['name']){
                if(md5($_POST["password"]) == $arr["password"]){
                    _d('authenticated');
                    $_SESSION['login'] = 1;
                    header('Location: /bankas/saskaita.php');
                    die();
                };
            }
        }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/main.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

</head>
<body>

    <div class="container">

        <div class="form">
        <h1>Prisijungimas</h1>
        <div class="line"></div>
        <form action="" method="post">

        <label for="name"> Vardas <br>
            <input type="text" name="name"> <br>
        </label>

        <label for="password"> Slaptazodis <br>
            <input type="password" name="password"> <br>
        </label>
        
        <button type="submit">Prisijungti</button>
        </form>
        </div>

        <div class="lock">
            <div class="lock-box">
                <i class="icon-lock"></i>
            </div>
        </div>
    </div>
</body>
</html>