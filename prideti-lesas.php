<?php

session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header('Location: /grazus/bankas/login.php');
    die();
}


if(!empty($_POST)){

    $data = json_decode(file_get_contents(__DIR__ .'/data.json'),1);

    if(array_key_exists('sum', $_POST)){
        foreach($data as &$value){
            if($value['account'] == $_POST['account']){
                $value['lesos'] += $_POST['sum'];
                $_SESSION['note'] = 'Pinigai prideti sekmingai';
            }
        }

        file_put_contents(__DIR__ .'/data.json', json_encode($data));

        header("Location: /grazus/bankas/prideti-lesas.php?account=".$_POST['account']."");
        die();
    }

    $input = '<form action="/grazus/bankas/prideti-lesas.php" method="post">
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

    $input = '<form action="/grazus/bankas/prideti-lesas.php" method="post">
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


?>

<!DOCTYPE html>
<html lang="en">
<head>

    <style>
        table, th, td {
        border: 1px solid black;
        }
    </style> 

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nurasyti lesas</title>
</head>
<body>

    <p><?php  
        
        if(isset($_SESSION['note'])) {
            echo $_SESSION['note'];
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

    <a href="/grazus/bankas/saskaitu-sarasas.php">Perziureti visas saskaitas</a><br>
    <a href="/grazus/bankas/login.php?logout">Atsijungti</a><br>
</body>
</html>