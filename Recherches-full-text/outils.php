<?php

$stopWords = <<<EOD
a afin ah ai ainsi allo allons alors apres assez au aucun aucune aucuns aussi autre aux 
auquel auxqels aura auront aussi autre autres avait avant avec avoir ayant
bah bon beaucoup bien
c ca car ce ceci cela celle celleci cellela celles celui celuici celuila 
cependant certains certaines ces cet cette ceux ceuxci ceuxla chacun chacune 
chaque ci combien comme comment contre
d dans de dela depuis des desormais desquels desquelles du duquel 
devrait doit donc dont
elle meme elles en encore entre envers est et etc etait etaient etions ete etre eu
fait faites fois font hors ici il ils je juste
l la le les leur m ma maintenant mais mes mien moins mon meme
ni notre nous ou par parce parmi pas peut peu plupart plus plusieurs pour pourquoi
qu quand que quel quelle quelles quels qui
s sa sans se ses seulement si sien son sont sous soyez sur
t ta tandis tellement tels tes ton tous tout trop tres tu
un une voient vont votre vous vu
EOD;
$stopWords = str_replace("\n", ' ', $stopWords);
$stopWords = str_replace("\r", ' ', $stopWords);
$stopWords = str_replace("  ", ' ', $stopWords);
$stopWords = explode(" ", $stopWords);


    function separerMots($texte) {
        global $stopWords;

        // Échapper les apostrophes:
        $texte = str_replace("'", "\'", $texte);

        // Mettre en minuscules:
        $texte = strtolower($texte);

        // Supprimer la ponctuation :
        $texte = preg_replace("/[[:punct:]]+/", " ", $texte);
    
        // Supprimer les accents:
        $texte = str_replace(
            array('à','á','â','ã','ä','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ'),
            array('a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','u','y','y'),
            $texte);

        // Supprimer les sauts de ligne:
        $texte = str_replace("\r", ' ', $texte);
        $texte = str_replace("\n", ' ', $texte);

        // Retirer les marques de pluriel :
        $texte = str_replace('aux ', 'al', $texte.' ');
        $texte = str_replace('s ', ' ', $texte);
        $texte = str_replace('x ', ' ', $texte);

        // Supprimer les espaces successifs et les espaces en début et à la fin :   
        $texte = str_replace('  ', ' ', $texte);
        $texte = str_replace('  ', ' ', $texte);
        $texte = trim($texte);

        // Séparer les mots (tokenisation) :
        $mots = explode(' ', $texte);

        // Retirer les mots vides:
        $mots = array_diff($mots, $stopWords);

        // NGram : Ne garder que les 4 premières lettres :

        $newMots = Array();
        foreach($mots as $mot) {
            $newMots[] = substr($mot, 0, 4);
        }
        return $mots;
    }

?>