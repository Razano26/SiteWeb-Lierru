<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barre de progression</title>
    <link rel="stylesheet" href="style/style.css">
</head>
    <body>
        <?php
                echo "<h1>Exécution des fichiers de requêtes SQL pour constituer la base de données</h1>";
                echo("<br/>");

                $dsn = 'mysql:host=localhost;dbname=PS3_V2;port=3306;charset=utf8mb4';

                $pdo = new PDO($dsn, 'root' , 'stidps3');     
                
                $query = $pdo->query("SET FOREIGN_KEY_CHECKS = 0;");

                $query = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'PS3_V2';");
                $resultat = $query->fetchAll();

                foreach ($resultat as $key => $variable){
                    $query = $pdo->query("DROP TABLE IF EXISTS ".$resultat[$key]['table_name'].";");
                }
                $query = $pdo->query("SET FOREIGN_KEY_CHECKS = 1;");

                $lire = file_get_contents("script/MCD-Lierru_MySQL-V2.txt");
                $query = $pdo->query($lire);
                
                // Fichiers de requêtes au format texte SQL à exécuter
                $SQL01="script/SQL01_Création_Manuelle_des_données.sql";
                $SQL02="script/SQL02_AUTOMATISE_GPS_thermometres_arbres.sql";
                $SQL035="script/SQL03_5_AUTOMATISE_heure_date.sql";
                $SQL03="script/SQL03_AUTOMATISE_Relevés_thermometres.sql";
                $SQL04="script/SQL04_AUTOMATISE_codes_arbres.sql";
                $SQL05="script/SQL05_MANUEL_Arbres_releves_fructification.sql";
                $SQL06="script/SQL06_MANUEL_Sangliers_comptage.sql";
                $SQL07="script/SQL07_MANUEL_Sangliers_prelevements.sql";
                $SQL08="script/SQL08_AUTOMATISE_Donnee_externe.sql";

                $tabSQL=[$SQL01,$SQL02,$SQL035,$SQL03,$SQL04,$SQL05,$SQL06,$SQL07,$SQL08];

#                $tabSQL=[$SQL01,$SQL02];

                // Parcours des fichiers de requêtes SQL
                foreach($tabSQL as $fichierSQL){
                        echo "<h2>Requêtes du fichier: <span>$fichierSQL</span> exécutées.</h2>\r\n";
                        echo("<br/>");
                        foreach(file($fichierSQL) as $line) {
                        $query = $pdo->query($line);
                        }
                    }
                echo("<br/>");
                echo("<h3>\r\nExécution de l'ensemble des requêtes SQL terminée</h3>");

                echo(test);
            ?>
    </body>
</html>