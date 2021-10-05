<?php
    require_once('db.php');
    require_once('outils.php');

    if(isSet($_GET['recherche'])) {
        $mots = separerMots($_GET['recherche']);


        $where = 'FALSE';
        foreach($mots as $mot) {
            $where = $where . " OR mot LIKE '" . $mot . "%',";
        }
        $where = rtrim($where, ',');

        $sql = "SELECT r.no_region, r.nom, SUM(d.occurrences)
                FROM dictionnaire AS d JOIN regions2016 AS r ON d.id_doc = r.no_region
                WHERE {$where} 
                GROUP BY r.no_region, r.nom
                ORDER BY SUM(d.occurrences) DESC
                ";

        $db = new DB();
        $q = $db->prepare($sql);
        $q->execute();

    }
    
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width;=device-width, initial-scale=1.0">
    <title>Recherche par dictionnaire</title>
    <style>
        body {text-align:center;}
    </style>
</head>
<body>
    <h1>Recherche par dictionnaire (index).</h1>
    <form name="frm" method="get" action="">
        <input type="text" name="recherche" />
        <input type="submit" value="Envoyer"/>
    </form>
    <?php
        if(isSet($q)) {
            while($data = $q->fetchObject()) {
                echo '<p>' . $data->nom . '</p>';
            }
        }
    ?>
 </body>
</html>











<!--
       <div id="resultat"><?php
        echo "<h2>Résultats pour {$sqlIn}</h2>";
        while($data = $q->fetchObject()) {
            echo "<p>{$data->nom}</p>";
        }
    ?></div>
-->