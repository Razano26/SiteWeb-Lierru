<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style/stylepage.css">
        <title>new</title>
    </head>
    
    <body class="centrer">
        <?php 
            echo("<h1>Partie MODIFIER.</h1><br/> <h4>On peut modifier une ligne dans plusieurs tables de la base de données, il suffit de choisir la thématique concernée dans le formulaire ci-dessous :  </h4>");

            if (isset($_POST["Table"])) 
                $Table=$_POST["Table"];
                $dsn = 'mysql:host=localhost;dbname=PS3_V2;port=3306;charset=utf8mb4';
                $pdo = new PDO($dsn, 'root' , 'stidps3'); 
        ?>

        <div class="menu">
            <form method="POST">
                <select name="Table">
                    <option value="Arbre" <?php if($Table == "Arbre") echo"selected" ?>>Arbre</option>
                    <option value="Meteo" <?php if($Table == "Meteo") echo"selected" ?>>Météo</option>
                </select>
                <input type="submit"></input>
            </form>
        </div>

        <?php 
            switch($Table){
                case "Arbre": ?>
                    <table border="1">
                        <thead><tr><th colspan="6">Arbre</th></tr></thead>
                        <tbody>
                            <?php
                                $requete = $pdo->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Arbre'");
                                $entetes = $requete->fetchAll();
                                echo("<tr>");
                                foreach($entetes as $key => $variable)
                                {
                                  echo("<td>".$entetes[$key]['COLUMN_NAME']."</td>");
                                }
                                echo("</tr>");

                                $query = $pdo->query("SELECT * from Arbre ORDER BY id_arbre;");
                                $resultat = $query->fetchAll();


                                foreach ($resultat as $key => $variable){
                                    echo("<tr><td>".$resultat[$key]['id_arbre']."</td><td>".$resultat[$key]['essence']."</td><td>".$resultat[$key]['type']."</td><td>".$resultat[$key]['id_position']."</td><td>".$resultat[$key]['id_groupement']."</td><td><a href=\"ALTER/ALTER_Arbre.php?id=".$resultat[$key]['id_arbre']."\">Modifier</a></td></tr>");
                                }
                            ?>
                        </tbody>
                    </table>
 
        <?php 
                    break;
                case "Meteo": ?>
                     <table border="1">
                        <thead><tr><th colspan="5">Thermometre</th></tr></thead>
                        <tbody>
                            <?php
                                $requete = $pdo->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Thermometre'");
                                $entetes = $requete->fetchAll();
                                echo("<tr>");
                                foreach($entetes as $key => $variable)
                                {
                                  echo("<td>".$entetes[$key]['COLUMN_NAME']."</td>");
                                }
                                echo("</tr>");

                                $query = $pdo->query("SELECT Donnees_externes.id_meteo, vent, temp, annee_mois FROM Donnees_externes, relever_meteo WHERE Donnees_externes.id_meteo=relever_meteo.id_meteo ORDER BY id_meteo;");
                                $resultat = $query->fetchAll();

                                foreach ($resultat as $key => $variable){
                                    echo("<tr><td>".$resultat[$key]['id_meteo']."</td><td>".$resultat[$key]['vent']."</td><td>".$resultat[$key]['temp']."</td><td>".$resultat[$key]['annee_mois']."</td><td><a href=\"ALTER/ALTER_Meteo.php?id=".$resultat[$key]['id_meteo']."\">Modifier</a></td></tr>");
                                }
                            ?>
                        </tbody>
                    </table>
        <?php } ?>  

    </body>
</html>