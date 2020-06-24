<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header('Location: ./login.php');
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

    return '<form action="./prideti-lesas.php" method="post">
            <input type="hidden" name="name" value="'.$name.'">
            <input type="hidden" name="surename" value="'.$surename.'">
            <input type="hidden" name="account" value="'.$saskaita.'">
            <input type="hidden" name="user-nr" value="'.$asmensKodas.'">
            <input type="hidden" name="lesos" value="'.$lesos.'">
            <button style="background-color: green" type="submit">Prideti Lesas</button>
            </form>';
            
}

function generateRemove ($name, $surename, $saskaita, $asmensKodas, $lesos){

    return '<form action="./nuskaiciuoti-lesas.php" method="post">
            <input type="hidden" name="name" value="'.$name.'">
            <input type="hidden" name="surename" value="'.$surename.'">
            <input type="hidden" name="account" value="'.$saskaita.'">
            <input type="hidden" name="user-nr" value="'.$asmensKodas.'">
            <input type="hidden" name="lesos" value="'.$lesos.'">
            <button style="background-color: yellow" type="submit">Nurasyti Lesas</button>
            </form>';

}

function delete ($saskaita){

    return '<form action="./istrinti.php" method="post">
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
        button{
            width: 110px;
            margin-bottom: 2px;
            cursor: pointer;    
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

    <div class="menu">
        <a href="./saskaita.php">Sukurti nauja saskaita</a><br>
        <a href="./login.php?logout">Atsijungti <i class="icon-signout text-icon"></i> </a><br>
    </div>   

</body>
</html>