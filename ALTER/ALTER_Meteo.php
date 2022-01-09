<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../style/stylepage.css">
        <title>Document</title>
    </head>

    <body>
        <?php
            $dsn = 'mysql:host=localhost;dbname=PS3_V2;port=3306;charset=utf8mb4';
            $pdo = new PDO($dsn, 'root' , 'stidps3');

            if (isset($_GET["id"])) 
                $id=$_GET["id"]
            ?>
            <table border="1">
                <thead>
                    <tr>
                        <th colspan="5">Meteo</th>
                    </tr>
                </thead>
            <tbody>
                <?php
                    $query = $pdo->query("SELECT Donnees_externes.id_meteo, vent, temp, annee_mois FROM Donnees_externes, relever_meteo WHERE Donnees_externes.id_meteo=relever_meteo.id_meteo AND Donnees_externes.id_meteo = '$id';");
                    $resultat = $query->fetchAll();
                
                    foreach ($resultat as $key => $variable){
                        echo("<tr><td>".$resultat[$key]['id_meteo']."</td><td>".$resultat[$key]['vent']."</td><td>".$resultat[$key]['temp']."</td><td>".$resultat[$key]['annee_mois']."</td></tr>");
                    }
                ?>
                <tr>
                    <form action="" method="get" >
                        <td></td>
                        <td>
                            <input type="number" name="vent" value="<?php foreach ($resultat as $key => $variable){echo($resultat[$key]['vent']);} ?>"></input>
                        </td>
                        <td>
                            <input type="number" name="temp" value="<?php foreach ($resultat as $key => $variable){echo($resultat[$key]['temp']);} ?>"></input>
                        </td>
                        <td></td>
                        <td>
                            <input type='hidden' name=id value=<?php echo($id) ?>></input>
                            <input type='hidden' name=valid value=TRUE></input>
                            <input type="submit" value="Modifer">
                        </td>
                    </form>
                </tr>
            </tbody>
        </table>
        <?php 
            if ($_GET["valid"] == TRUE){
#                echo("UPDATE `Donnees_externes` SET `vent` = '".$_GET["vent"]."',`temp` = '".$_GET["temp"]."' WHERE `Donnees_externes`.`id_meteo` = '".$_GET["id"]."';");
                $query = $pdo->query("UPDATE `Donnees_externes` SET `vent` = '".$_GET["vent"]."',`temp` = '".$_GET["temp"]."' WHERE `Donnees_externes`.`id_meteo` = '".$_GET["id"]."';");
            }
        ?>
    </body>
</html>