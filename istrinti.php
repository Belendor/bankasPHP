<?php 
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header('Location: ./login.php');
    die();
}

if(array_key_exists('delete', $_POST)){

    $data = json_decode(file_get_contents(__DIR__ .'/data.json'),1);

    foreach($data as $key => $value){

        if($_POST['delete'] == $value['account']){

            if($value['lesos'] > 0){

                $_SESSION['note'] = [
                    "message" => "error",
                    "text" => 'Toks asmens kodas jau yra uzimtas'
                ];

            }else{
                array_splice($data, $key, 1);

                $_SESSION['note'] = [
                    "message" => "error",
                    "text" => 'Toks asmens kodas jau yra uzimtas'
                ];
                
            }
        }
    }


    file_put_contents(__DIR__ .'/data.json', json_encode($data));

    header("Location: ./saskaitu-sarasas.php");
    die();
}

