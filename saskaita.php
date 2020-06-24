<?php 

session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header('Location: ./login.php');
    die();
}

if(!empty($_POST) && !empty($_POST['name'])){


    if(strlen($_POST['user-nr']) != 11){
        $_SESSION['note'] = 'Neteisingas asmens kodo formatas';
        header("Location: ./saskaita.php");
        die();
    }

    if(strlen($_POST['name']) < 3){
        $_SESSION['note'] = 'Vardas yra per trumpas';
        header("Location: ./saskaita.php");
        die();
    }

    if(strlen($_POST['surename']) < 3){
        $_SESSION['note'] = 'Pavarde yra per trumpa';
        header("Location: ./saskaita.php");
        die();
    }

    $data = json_decode(file_get_contents(__DIR__ .'/data.json'),1);

    $uniqueId = true;


    foreach($data as $value){

        if($value['user-nr'] == $_POST['user-nr']){
           
            $uniqueId = false;
        }

    }

    if($uniqueId){

        $name = $_POST['name'];
        $surename = $_POST['surename'];
        $account = $_POST['account'];
        $userNr = $_POST['user-nr'];
    
        $newObject = [
            'name'=> $name,
            'surename' => $surename,
            'account' => $account,
            'user-nr' => $userNr,
            'lesos' => 0
        ];
    
        $data[] = $newObject;
    
        file_put_contents(__DIR__ .'/data.json', json_encode($data));

        $_SESSION['note'] = [
            "message" => "message",
            "text" => 'Nauja saskaita sukurta sekmingai'
        ];

        header("Location: ./saskaita.php");
        die();

    }else{

        $_SESSION['note'] = [
            "message" => "error",
            "text" => 'Toks asmens kodas jau yra uzimtas'
        ];

        header("Location: ./saskaita.php");
        die();
    }

}

function generateIban(){
    $string = 'LT';

    for($i = 0; $i<18; $i++){
        $randNr = rand(0,9);
        $string .= $randNr;
    }

    return $string;
}

function generateID(){
    $string = '';

    $string .= rand(1,6);
    $string .= str_pad(rand(0,99), 2, "0", STR_PAD_LEFT);
    $string .= str_pad(rand(1,12), 2, "0", STR_PAD_LEFT);
    $string .= str_pad(rand(1,31), 2, "0", STR_PAD_LEFT);

    for($i = 0; $i<4; $i++){
        $randNr = rand(0,9);
        $string .= $randNr;
    }

    return $string;
}

$errorColor = '';

if(isset($_SESSION['note'])){
    if($_SESSION['note']['message'] == 'message'){
        $errorColor = 'green';
    }else{
        $errorColor = 'red';
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saskaitos</title>

    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/main.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

</head>
<body>

    <div class="container">

        <div class="form">
            <h1>Nauja Saskaita</h1>
            <div class="line"></div>

                <p class="message <?=$errorColor?> "><?php  
        
                    if(isset($_SESSION['note'])) {
                    
                        echo $_SESSION['note']['text'];
                        unset($_SESSION['note']);
                        
                    }

                ?></p><br>

            <form action="" method="post">
                <label for="name"> Vardas: <br>
                    <input id="input-name" type="text" name="name" required> <br>
                    <p class="name-error error"></p>
                </label> 
                <label for="surename"> Pavarde: <br>
                    <input id="input-surename" type="text" name="surename" required> <br>
                    <p class="surename-error error"></p>
                </label>
                <label for="account"> Saskaitos Numeris: <br>
                    <input type="text" name="account" value="<?=generateIban()?>" readonly required><br>
                </label>
                <label for="user-nr"> Asmens kodas:  <br>
                    <input id="input-id" type="number" name="user-nr" value="<?=generateID()?>" required><br>
                    <p class="id-error error"></p>
                </label>
                <button type="submit">Prideti</button>
            </form>

            <div class="line"></div>

            <div class="menu">
                <a href="./saskaitu-sarasas.php">Perziureti saskaitu sarasa <i class="text-icon icon-external-link"></i></a><br>
                <a href="./login.php?logout">Atsijungti <i class="icon-signout text-icon"></i> </a><br>
            </div>

        </div>

        <div class="lock">
            <div class="lock-box">
                 <i class="icon-user"></i>
            </div>
        </div>
    </div>

    <script src="./js/script.js"></script>

</body>
</html>