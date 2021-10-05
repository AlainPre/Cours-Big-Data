<?php
    require('db.php');
    require('outils.php');

    $db = new DB();

    // Vider la table dictionnaire:

    $q = $db->prepare("TRUNCATE dictionnaire");
    $q->execute();

    // Générer le dictionnaire :

    $q = $db->prepare("SELECT no_region, nom, description FROM regions2016");
    $q->execute();
    while($data = $q->fetchObject()) {
        $mots = separerMots($data->nom . ' '. $data->description);
        foreach($mots as $mot) {
            $q2 = $db->prepare("INSERT IGNORE INTO  dictionnaire (mot, id_doc, occurrences) 
                                VALUES ( '{$mot}', '{$data->no_region}', 0) 
                            ");
            $q2->execute();

            $q3 = $db->prepare("UPDATE dictionnaire SET occurrences = occurrences + 1
                                WHERE mot = '{$mot}' AND id_doc = '{$data->no_region}'
                            ");
            $q3->execute();
        }
    }



?>