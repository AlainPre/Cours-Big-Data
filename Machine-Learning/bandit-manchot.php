<?php
    session_start();
     
 //   $origin = $_SERVER['HTTP_ORIGIN'];
    $origin = 'localhost';
    if(strpos("http://localhost", $origin) !== FALSE ) {
        header("Access-Control-Allow-Origin: " . 'http://localhost');
    }
    if(strpos("http://127.0.0.1", $origin) !== FALSE ) {
        header("Access-Control-Allow-Origin: " . 'http://127.0.0.1');
    }
    define('NB_MACHINES', 100);
    
    if(isSet($_GET['no'])) {
        $no = $_GET['no'];
    }
    else {
        header("Status: 400 Bad Request");
        echo "Le paramètre no est requis.";
        die();
    }
    if($no < 1 or $no > NB_MACHINES) {
        header("Status: 400 Bad Request");
        echo "Le paramètre no doit être compris entre 1 et ", NB_MACHINES, '.';
        die();
    }

     // Le seuil doit être fixé entre 0 (aucune chance) et 100 (gain systématique)

    for($i=1; $i <= NB_MACHINES; $i++) {
        $seuil[$i] = 20;     $gainMax[$i] = 4;
    }

    // Machines gagnant plus souvent :

    $seuil[10] = 70;     $gainMax[10] = 4;
    $seuil[18] = 60;     $gainMax[18] = 4;
    $seuil[22] = 50;     $gainMax[22] = 4;
    $seuil[25] = 40;     $gainMax[25] = 4;
    $seuil[34] = 30;     $gainMax[34] = 4;

    // Machines gagnant plus :

    $seuil[41] = 20;     $gainMax[41] = 30;
    $seuil[48] = 20;     $gainMax[48] = 25;
    $seuil[50] = 20;     $gainMax[50] = 20;
    $seuil[55] = 20;     $gainMax[55] = 15;
    $seuil[61] = 20;     $gainMax[61] = 10;
  
    $gain = jouer($no);
    header("Content-Type: application/json");
    echo '{"resultat": {"no": ' . $no . ', "gain": ' . $gain . '}}';


    function jouer($no) {
        global $seuil, $gainMax;

        srand(time());
        $tirage = rand(0,100);    
        if($tirage < $seuil[$no]) {
            $gain = rand(1, $gainMax[$no]);
        }
        else {
            $gain = 0;
        }
        return $gain;
    }
 ?>