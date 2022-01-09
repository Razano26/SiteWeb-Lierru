<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Execution script</title>
</head>
    <body>
        <?php

            // Fichiers de requêtes au format texte SQL à exécuter
            $MCD="MCD-Lierru_MySQL-V2.sql";
            $SQL01="SQL01_Création_Manuelle_des_données.sql";
            $SQL02="SQL02_AUTOMATISE_GPS_thermometres_arbres.sql";
            $SQL035="SQL03_5_AUTOMATISE_heure_date.sql";
            $SQL03="SQL03_AUTOMATISE_Relevés_thermometres.sql";
            $SQL04="SQL04_AUTOMATISE_codes_arbres.sql";
            $SQL05="SQL05_MANUEL_Arbres_releves_fructification.sql";
            $SQL06="SQL06_MANUEL_Sangliers_comptage.sql";
            $SQL07="SQL07_MANUEL_Sangliers_prelevements.sql";
            $SQL08="SQL08_AUTOMATISE_Donnee_externe.sql";

            $tabSQL=[$MCD,$SQL01,$SQL02,$SQL035,$SQL03,$SQL04,$SQL05,$SQL06,$SQL07,$SQL08];

            $dsn = 'mysql:host=localhost;pdoname=PS3_V2;port=3306;charset=utf8mb4';
            $pdo = new PDO($dsn, 'root' , 'stidps3');

            echo "<h1 style='color:red'>Parcours des fichiers de requête SQL et exécution des requêtes</h1>\r\n";
            
            echo "<h2>Suppression de toutes les tables existantes de la base de données:</h2>\r\n";
            echo "<h3 style='color:blue'>DROP table;<br/></h3>\r\n";


            $sql = 'DROP TABLE Lieu';
            $pdo->prepare($sql);


#           // Parcours des fichiers de requêtes SQL
#           foreach($tabSQL as $fichierSQL){
#               echo "<h2>Parcours des requêtes du fichier: <span style='color:blue'>$fichierSQL</span></h2>\r\n";
#
#               $sql=(file_get_contents($fichierSQL));
#               $sth = $pdo->prepare($sql);
#           }


            $pdo->connection = null;

        ?>
    </body>
</html>