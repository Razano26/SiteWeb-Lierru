<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barre de progression</title>
    <link rel="stylesheet" href="style.css">
</head>
    <body>
        <div class="progress">
            <span class="lettre">C</span>
            <span class="lettre">H</span>
            <span class="lettre">A</span>
            <span class="lettre">R</span>
            <span class="lettre">G</span>
            <span class="lettre">E</span>
            <span class="lettre">M</span>
            <span class="lettre">E</span>
            <span class="lettre">N</span>
            <span class="lettre">T</span>
        </div>
        <div class="accueil">
        <?php
        $dsn = 'mysql:host=localhost;dbname=PS3_V2;port=3306;charset=utf8mb4';

        $pdo = new PDO($dsn, 'root' , 'stidps3');     
        
        $query = $pdo->query("SET FOREIGN_KEY_CHECKS = 0;");

        $query = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'PS3_V2';");
        $resultat = $query->fetchAll();

        foreach ($resultat as $key => $variable){
            $query = $pdo->query("DROP TABLE IF EXISTS ".$resultat[$key]['table_name'].";");
        }
        $query = $pdo->query("SET FOREIGN_KEY_CHECKS = 1;");

        $lire = file_get_contents("MCD-Lierru_MySQL-V2.txt");
        $query = $pdo->query($lire);
        
        // Fichiers de requêtes au format texte SQL à exécuter
        $SQL01="SQL01_Création_Manuelle_des_données.sql";
        $SQL02="SQL02_AUTOMATISE_GPS_thermometres_arbres.sql";
        $SQL035="SQL03_5_AUTOMATISE_heure_date.sql";
        $SQL03="SQL03_AUTOMATISE_Relevés_thermometres.sql";
        $SQL04="SQL04_AUTOMATISE_codes_arbres.sql";
        $SQL05="SQL05_MANUEL_Arbres_releves_fructification.sql";
        $SQL06="SQL06_MANUEL_Sangliers_comptage.sql";
        $SQL07="SQL07_MANUEL_Sangliers_prelevements.sql";
        $SQL08="SQL08_AUTOMATISE_Donnee_externe.sql";

#        $tabSQL=[$SQL01,$SQL02,$SQL035,$SQL03,$SQL04,$SQL05,$SQL06,$SQL07,$SQL08];
        $tabSQL=[$SQL01,$SQL02,$SQL035];


           // Parcours des fichiers de requêtes SQL
           foreach($tabSQL as $fichierSQL){
                echo "<h2>Parcours des requêtes du fichier: <span style='color:blue'>$fichierSQL</span></h2>\r\n";
                foreach(file($fichierSQL) as $line) {
                $query = $pdo->query($line);
                }
            }
        ?>
        </div>
        <script src="app.js"></script>
    </body>
</html>