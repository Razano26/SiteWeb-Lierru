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
                $id=$_GET["id"];
            ?>
            <table border="1">
                <thead>
                    <tr>
                        <th colspan="5">Arbre</th>
                    </tr>
                </thead>
            <tbody>
                <?php
                    $query = $pdo->query("SELECT * from Arbre where id_arbre='$id';");
                    $resultat = $query->fetchAll();
                    
                    
                
                    foreach ($resultat as $key => $variable){
                        echo("<tr><td>".$resultat[$key]['id_arbre']."</td><td>".$resultat[$key]['essence']."</td><td>".$resultat[$key]['type']."</td><td>".$resultat[$key]['id_position']."</td><td>".$resultat[$key]['id_groupement']."</td></tr>");
                    }
                ?>
                <tr>
                    <form action="" method="get" >
                        <td>
                        <input type='text' placeholder="identifiant de l'arbre" name='id_arbre'></input>
                        </td><td>
                        <select name='essence'>
                                <option value=''></option>
                                <option value='Chêne pédonculé'>Chêne pédonculé</option>
                                <option value='Chêne sessile'>Chêne sessile</option>
                                <option value='Hêtre commun'>Hêtre commun</option>
                        </select>
                        </td><td></td><td></td><td>
                        <select name='id_groupement'>
                            <option value=''></option>
                            <option value='B'>Groupement du Bénitier</option>
                            <option value='D'>Groupement du Haras(Doré) et de la Bourgeraie</option>
                            <option value='E'>Groupement de l'Etang</option>
                            <option value='P'>Groupement du Lierru</option>
                        </select>
                        </td><td>
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
                $query = $pdo->query("SET FOREIGN_KEY_CHECKS = 0;");
                $query = $pdo->query("UPDATE `relever_houppier` SET `id_arbre` = '".$_GET["id_arbre"]."' WHERE `relever_houppier`.`id_arbre` = '".$_GET["id"]."';");
#                echo("UPDATE `relever_houppier` SET `id_arbre` = '".$_GET["id_arbre"]."' WHERE `relever_houppier`.`id_arbre` = '".$_GET["id"]."';<br/>");
            
                $query = $pdo->query("UPDATE `Arbre` SET `id_arbre` = '".$_GET["id_arbre"]."', `essence` = '".$_GET["essence"]."', `id_groupement` = '".$_GET["id_groupement"]."' WHERE `Arbre`.`id_arbre` = '".$_GET["id"]."';");
#                echo("UPDATE `Arbre` SET `id_arbre` = '".$_GET["id_arbre"]."', `essence` = '".$_GET["essence"]."', `id_groupement` = '".$_GET["id_groupement"]."' WHERE `Arbre`.`id_arbre` = '".$_GET["id"]."';");
                $query = $pdo->query("SET FOREIGN_KEY_CHECKS = 1;");
            }
        ?>
    </body>
</html>