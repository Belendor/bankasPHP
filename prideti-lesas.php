<?php

session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header('Location: ./login.php');
    die();
}


if(!empty($_POST)){

    $data = json_decode(file_get_contents(__DIR__ .'/data.json'),1);

    if(array_key_exists('sum', $_POST)){
        foreach($data as &$value){
            if($value['account'] == $_POST['account']){
                $value['lesos'] += $_POST['sum'];

                $_SESSION['note'] = [
                    "message" => "message",
                    "text" => 'Pinigai prideti sekmingai'
                ];
                
            }
        }

        file_put_contents(__DIR__ .'/data.json', json_encode($data));

        header("Location: ./prideti-lesas.php?account=".$_POST['account']."");
        die();
    }

    $input = '<form action="./prideti-lesas.php" method="post">
            <input type="number" name="sum">
            <input type="hidden" name="name" value="'.$_POST['name'].'">
            <input type="hidden" name="surename" value="'.$_POST['surename'].'">
            <input type="hidden" name="account" value="'.$_POST['account'].'">
            <input type="hidden" name="user-nr" value="'.$_POST['user-nr'].'">
            <input type="hidden" name="lesos" value="'.$_POST['lesos'].'">
            <button type="submit">Prideti Lesas</button>
            </form>';

    $renderRow = '<tr>
                <td>'.$_POST['name'].'</td>
                <td>'.$_POST['surename'].'</td>
                <td>'.$_POST['account'].'</td>
                <td>'.$_POST['user-nr'].'</td>
                <td>'.$_POST['lesos'].'</td>
                <td>'.$input.'</td>
                </tr>';

}

if(!empty($_GET)){

    $data = json_decode(file_get_contents(__DIR__ .'/data.json'),1);
    $selected = [];

    foreach($data as $array){

        if($_GET['account'] == $array['account']){
            $selected = $array; 
        }

    }

    $input = '<form action="./prideti-lesas.php" method="post">
            <input type="number" name="sum" min="0">
            <input type="hidden" name="name" value="'.$selected['name'].'">
            <input type="hidden" name="surename" value="'.$selected['surename'].'">
            <input type="hidden" name="account" value="'.$selected['account'].'">
            <input type="hidden" name="user-nr" value="'.$selected['user-nr'].'">
            <input type="hidden" name="lesos" value="'.$selected['lesos'].'">
            <button type="submit">Prideti Lesas</button>
            </form>';


    $renderRow = '<tr>
                <td>'.$selected['name'].'</td>
                <td>'.$selected['surename'].'</td>
                <td>'.$selected['account'].'</td>
                <td>'.$selected['user-nr'].'</td>
                <td>'.$selected['lesos'].'</td>
                <td>'.$input.'</td>
                </tr>';
}

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

    <style>

        td, th {
        border: 1px solid #ddd;
        padding: 8px;
        }

        tr:nth-child(even){background-color: #f2f2f2;}

        tr:hover {background-color: #ddd;}

        th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #0092E1;
        color: white;
        }
        .menu{
            display: inline-block;
            padding: 5px 0;
        }

        a{
            font-family: 'SEB Sans Serif';
            text-decoration: unset;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .red{
            background-color: rgba(201, 63, 63, 0.74);
        }

        .green{
            background-color: rgba(35, 173, 35, 0.74);
        }

    </style> 

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nurasyti lesas</title>
</head>
<body>

    <p class="<?=$errorColor?> "><?php  
        
        if(isset($_SESSION['note'])) {
        
            echo $_SESSION['note']['text'];
            unset($_SESSION['note']);
            
        }

    ?></p><br>

    <table style="width:100%">
        <th>Vardas</th>
        <th>Pavarde</th> 
        <th>Saskaita</th>
        <th>Asmens kodas</th>
        <th>Lesos</th>
        <th>Kokia suma prideti?</th>

        <?=$renderRow ?? '' ?>

    </table>

    <div class="menu">
        <a href="./saskaita.php">Sukurti nauja saskaita</a><br>
        <a href="./saskaitu-sarasas.php">Perziureti saskaitu sarasa <i class="text-icon icon-external-link"></i></a><br>
        <a href="./login.php?logout">Atsijungti <i class="icon-signout text-icon"></i> </a><br>
    </div>
</body>
</html>