<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header('Location: /bankas/login.php');
    die();
}


$data = json_decode(file_get_contents(__DIR__ .'/data.json'),1);

$table = '';

function bubleSort($array){
    $swapped;
    do{
        $swapped = false;
        for($i = 0; $i < count($array) - 1; $i++){

            //------------------------------------------
            // Irasyti kokias arejaus reiksmes lyginti
            //------------------------------------------

            $firstElement = ord($array[$i]['surename'][0]);
            $secondElement = ord($array[$i+1]['surename'][0]);
            // -----------------------------------------


            if($firstElement > $secondElement){ // '>' Didejimo tvarka, '<' Mazejimo tvarka.
                $temp = $array[$i];
                $array[$i] = $array[$i + 1];
                $array[$i + 1] = $temp;
                $swapped = true;
            }
        }
    }while($swapped);
    return $array;
}

$sorted = bubleSort($data);


function generateAdd ($name, $surename, $saskaita, $asmensKodas, $lesos){

    return '<form action="/bankas/prideti-lesas.php" method="post">
            <input type="hidden" name="name" value="'.$name.'">
            <input type="hidden" name="surename" value="'.$surename.'">
            <input type="hidden" name="account" value="'.$saskaita.'">
            <input type="hidden" name="user-nr" value="'.$asmensKodas.'">
            <input type="hidden" name="lesos" value="'.$lesos.'">
            <button style="background-color: green" type="submit">Prideti Lesas</button>
            </form>';
            
}

function generateRemove ($name, $surename, $saskaita, $asmensKodas, $lesos){

    return '<form action="/bankas/nuskaiciuoti-lesas.php" method="post">
            <input type="hidden" name="name" value="'.$name.'">
            <input type="hidden" name="surename" value="'.$surename.'">
            <input type="hidden" name="account" value="'.$saskaita.'">
            <input type="hidden" name="user-nr" value="'.$asmensKodas.'">
            <input type="hidden" name="lesos" value="'.$lesos.'">
            <button style="background-color: yellow" type="submit">Nurasyti Lesas</button>
            </form>';

}

function delete ($saskaita){

    return '<form action="/bankas/istrinti.php" method="post">
            <input type="hidden" name="delete" value="'.$saskaita.'">
            <button style="background-color: red" type="submit">Istrinti saskaita</button>
            </form>';

}

foreach($sorted as $value){

    $row = "<tr>
            <td>".$value['name']."</td>
            <td>".$value['surename']."</td>
            <td>".$value['account']."</td>
            <td>".$value['user-nr']."</td>
            <td>".delete ($value['account'])." ".generateAdd($value['name'], $value['surename'], $value['account'], $value['user-nr'], $value['lesos'])." ".generateRemove($value['name'], $value['surename'], $value['account'], $value['user-nr'], $value['lesos'])." </td>
            </tr>";

    $table .= $row;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saskaitu sarasas</title>
    <style>
        table, th, td {
        border: 1px solid black;
        }
    </style>    
</head>
<body>

    <p><?php  
        
        if(isset($_SESSION['note'])) {
            echo $_SESSION['note'];
            unset($_SESSION['note']);
        }

    ?></p><br>

    <div style="width 100%; border: solid 1px black">
    <table style="width:100%">

        <tr>
        <th>Vardas</th>
        <th>Pavarde</th> 
        <th>Saskaita</th>
        <th>Asmens kodas</th>
        <th>Veiksmai</th>
        </tr>

        <?=$table?>

        </table>
    </div>

    <a href="/bankas/saskaita.php">Sukurti nauja saskaita</a><br>

    <a href="/bankas/login.php?logout">Atsijungti</a><br>

</body>
</html>