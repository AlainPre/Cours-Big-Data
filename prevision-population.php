<?php

    if(isSet($_GET['annee'])) {
        $annee = $_GET['annee'];
    }
    else {
        header('HTTP/1.1 400 Bad Request');
        header('Content-Type: application/json');
        echo <<<EOD
        {
            "résultat" : {
                "status": "Année inconnue",
                "année" : "",
                "population" : ""
            }
        }
        EOD;
        die();      // Stopper le code
    }

    $annees[] = 1985;    $populations[] = 	 56.445 ;
    $annees[] = 1990;    $populations[] = 	 57.996 ;
    $annees[] = 1995;    $populations[] = 	 59.281 ;
    $annees[] = 2000;    $populations[] = 	 60.508 ;
    $annees[] = 2005;    $populations[] = 	 62.731 ;
    $annees[] = 2010;    $populations[] = 	 64.613 ;
    $annees[] = 2012;    $populations[] = 	 65.241 ;
    $annees[] = 2013;    $populations[] = 	 65.565 ;
    $annees[] = 2014;    $populations[] = 	 66.131 ;
    $annees[] = 2015;    $populations[] = 	 66.423 ;
    $annees[] = 2016;    $populations[] = 	 66.603 ;
    $annees[] = 2017;    $populations[] = 	 66.775 ;
    $annees[] = 2018;    $populations[] = 	 66.884 ;
    $annees[] = 2019;    $populations[] = 	 66.978 ;
    $annees[] = 2020;    $populations[] = 	 67.064 ;

    $moyAnnees = array_sum($annees) / count($annees);
    $moyPopulation = array_sum($populations) / count($populations);

    $numerateur = 0;
    $denominateur = 0;
    for($i=0; $i<count($annees); $i++) {
        $diffAnMoy = $annees[$i] - $moyAnnees;
        $diffPopMoy = $populations[$i] - $moyPopulation;
        $prodDiff = $diffAnMoy * $diffPopMoy; 
        $carreDiffAn = $diffAnMoy * $diffAnMoy;
        $numerateur+= $prodDiff;
        $denominateur+= $carreDiffAn;
    }
    $a = $numerateur / $denominateur;
    $b = $moyPopulation - $a * $moyAnnees;

    $result = $a * $annee + $b;

    header('Content-Type: application/json');
    echo <<<EOD
        {
            "résultat" : {
                "status": "ok",
                "année": {$annee},
                "population": {$result}
            }
        }
    EOD;
?>