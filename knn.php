<?php

    // Examen des paramètres et valeurs par défaut :

    if(isSet($_GET['r']))   {$r = $_GET['r'];}
    else                    {$r = 0;}

    if(isSet($_GET['v']))   {$v = $_GET['v'];}
    else                    {$v = 0;}

    if(isSet($_GET['b']))   {$b = $_GET['b'];}
    else                    {$b = 0;}

    if(isSet($_GET['k'])) {     $k = $_GET['k'];}
    else {                      $k = 3;}

    // Lecture du fichier des données étiquetées :

    $f = fopen("couleurs.csv", "r");
    fgets($f);   // Eliminer la ligne des titres
    while(!feof($f)) {
        $couleur = fgets($f);
        if(strlen($couleur) > 2) {
            $data = explode(';', $couleur);
            $nom = $data[0];
            $rouges[$nom] = $data[1];
            $verts[$nom] = $data[2];
            $bleus[$nom] = $data[3];
            $types[$nom] = str_replace('"', '', $data[4]);
        }
    }
    fclose($f);

    // Calcul de la distance euclidienne :

    foreach($rouges as $nom => $value) {
        $dist[$nom] = sqrt( ($rouges[$nom] - $r)**2 + ($verts[$nom] - $v)**2 + ($bleus[$nom] - $b)**2 );
    }

    // Trier les distances euclidiennes :

    asort($dist);

    // Chercher le type des K plus proches voisins :

    $nChaudes = 0; $nFroides = 0; $nNeutres = 0; $n = 0;
    foreach($dist as $nom => $d) {
        $type = $types[$nom];
        if($type == "Chaude") {$nChaudes++;}
        if($type == "Froide") {$nFroides++;}
        if($type == "Neutre") {$nNeutres++;}
        $n++;
        if($n >= $k) {break;}
    }

    $max =  max($nChaudes, $nFroides, $nNeutres);
    if($max == $nChaudes) {$type = "Chaude";}
    if($max == $nFroides) {$type = "Froide";}
    if($max == $nNeutres) {$type = "Neutre";}

    // renvoyer la réponse en JSON :

header('Content-Type: application/json');
echo <<<EOD
{
    "Résultat": {
        "r": $r,
        "v": $v,
        "b": $b,
        "k": $k,
        "type": "$type"
    }
}
EOD;
?>