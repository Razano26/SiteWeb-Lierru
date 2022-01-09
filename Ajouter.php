<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/stylepage.css">
    <title>new</title>
    </head>
<body  class="centrer">
        <?php
        echo("<h1>Partie AJOUTER.</h1><br/> <h4>On peut ajouter une ligne dans plusieurs tables de la base de données, il suffit de choisir la thématique concernée dans le formulaire ci-dessous :  </h4>");
            if (isset($_POST["Table"]))   
                $Table=$_POST["Table"];
    #       else
    #         $Table="Arbre";
            if (isset($_POST["table_bis"]))   
                $Table=$_POST["table_bis"];
        ?>
        <div class="menu">
            <form method="POST">
                <select name="Table">
                    <option value="Arbre" <?php if($Table == "Arbre") echo"selected" ?>>Arbre</option>
                    <option value="Thermometre" <?php if($Table == "Thermometre") echo"selected" ?>>Thermometre</option>
                    <option value="Releve_glands" <?php if($Table == "Releve_glands") echo"selected" ?>>Relevé Glands</option>
                    <option value="Meteo" <?php if($Table == "Meteo") echo"selected" ?>>Météo</option>
                    <option value="Comptage_sangliers" <?php if($Table == "Comptage_sangliers") echo"selected" ?>>Comptage Sangliers</option>
                    <option value="Prelevement_sangliers" <?php if($Table == "Prelevement_sangliers") echo"selected" ?>>Prélèvement Sangliers</option>
                </select>
                <input type="submit"></input>
            </form>
        </div>
        <?php

        $dsn = 'mysql:host=localhost;dbname=PS3_V2;port=3306;charset=utf8mb4';
        $pdo = new PDO($dsn, 'root' , 'stidps3');  
        

        switch ($Table){
            case "Arbre":
                echo("<br/> <br/> <h4> Pour ajouter un arbre, vous devez compléter les champs suivants: id_arbre, essence, id_groupement, latitude, longitude. '</h4>");
                echo("<form method='POST'>
                        <input type='text' placeholder=\"identifiant de l'arbre\" name='id_arbre'></input>
                        <select placeholder='essence' name='essence'>
                            <option value=''></option>
                            <option value='Chêne pédonculé'>Chêne pédonculé</option>
                            <option value='Chêne sessile'>Chêne sessile</option>
                            <option value='Hêtre commun'>Hêtre commun</option>
                        </select>
                        <select placeholder='latitude' name='id_groupement'>
                            <option value=''></option>
                            <option value='B'>Groupement du Bénitier</option>
                            <option value='D'>Groupement du Haras(Doré) et de la Bourgeraie</option>
                            <option value='E'>Groupement de l'Etang</option>
                            <option value='P'>Groupement du Lierru</option>
                        </select>
                        <input type='text' placeholder='latitude' name=latitude></input>
                        <input type='text' placeholder='longitude' name=longitude></input>
                        <input type='hidden' name=table_bis value=$Table></input>
                        <input type='submit'></input
                    </form>");
                echo("<br/> <br/> <h4>L'identifiant de l'arbre est déterminé par la première lettre de son essence (P:chêne pédonculé, S:chêne sessile, H:hêtre commun), puis par un nombre.</h4>");
                if (isset($_POST["id_arbre"]))
                    $id_arbre=$_POST["id_arbre"];
                if (isset($_POST["essence"]))
                    $essence=$_POST["essence"];
                if (isset($_POST["id_groupement"]))
                    $id_groupement=$_POST["id_groupement"];
                if (isset($_POST["latitude"]))
                    $latitude=$_POST["latitude"];
                if (isset($_POST["longitude"]))
                    $longitude=$_POST["longitude"];
                switch ($essence){
                    case ("Chêne sessile"):
                        $type=27;
                    case ("Chêne pédonculé"):
                        $type=29;
                    case ("Hêtre commun"):
                        $type=0;
                    }
#               var_dump($_POST);
                $query = $pdo->query("INSERT INTO Coordonnee VALUES (\"$id_arbre\",$latitude,$longitude);
                                        INSERT INTO Arbre VALUES (\"$id_arbre\",\"$essence\",$type,\"$id_arbre\",\"$id_groupement\")");
                echo("\n<h2>La requête créée est 'INSERT INTO Coordonnee VALUES (\"$id_arbre\",$latitude,$longitude);
                                        INSERT INTO Arbre VALUES (\"$id_arbre\",\"$essence\",$type,\"$id_arbre\",\"$id_groupement\")'</h2>");
                break;
            case "Thermometre":
                echo("<br/> <br/> <h4>Pour ajouter un thermomètre, vous devez compléter les champs suivants: id_thermometre, id_groupement, latitude, longitude.</h4>");
                echo("<form method='POST'>
                        <input type='text' placeholder='id_thermometre' name=id_thermometre></input>
                        <select name='id_groupement'>
                            <option value=''></option>
                            <option value='B'>Groupement du Bénitier</option>
                            <option value='D'>Groupement du Haras(Doré) et de la Bourgeraie</option>
                            <option value='E'>Groupement de l'Etang</option>
                            <option value='P'>Groupement du Lierru</option>
                        </select>
                        <input type='text' placeholder='latitude' name=latitude></input>
                        <input type='text' placeholder='longitude' name=longitude></input>
                        <input type='hidden' name=table_bis value=$Table></input>
                        <input type='submit'></input>
                        </form>");
                    echo("<br/> <h4>L'identifiant du thermomètre est déterminé par la première lettre de son essence (P:chêne pédonculé, S:chêne sessile, H:hêtre commun), puis par un nombre.</h4>");
                    if (isset($_POST["id_thermometre"]))
                        $id_thermometre=$_POST["id_thermometre"];
                    if (isset($_POST["id_groupement"]))
                        $id_groupement=$_POST["id_groupement"];
                    if (isset($_POST["latitude"]))
                        $latitude=$_POST["latitude"];
                    if (isset($_POST["longitude"]))
                        $longitude=$_POST["longitude"];
#               var_dump($_POST);
                    $query = $pdo->query("INSERT INTO Coordonnee VALUES (\"$id_thermometre\",$latitude,$longitude);
                                          INSERT INTO Thermometre VALUES (\"$id_thermometre\",\"NULL\",\"$id_thermometre\",\"$id_groupement\")");
                    echo("\n<h2>La requête créée est 'INSERT INTO Coordonnee VALUES (\"$id_thermometre\",$latitude,$longitude);
                        INSERT INTO Thermometre VALUES (\"$id_thermometre\",\"$id_thermometre\",\"$id_groupement\")' </h2>");
                        
                echo("<br/><br/><h4>Pour ajouter un relevé lié à un thermomètre, vous devez compléter les champs suivants: id_thermometre,heure_relevé, date_relevé, temperature, rh, wb, dp.</h4>");
                echo("<form method='POST'>
                        <input type='text' placeholder='id_thermometre' name=id_thermometre></input>
                        <input type='text' placeholder='heure_relevé' name=heure_rel></input>
                        <input type='text' placeholder='date_relevé' name=date_rel></input>
                        <input type='text' placeholder='température' name=temperature></input>
                        <input type='text' placeholder='rh' name=rh></input>
                        <input type='text' placeholder='wb' name=wb></input>
                        <input type='text' placeholder='dp' name=dp></input>
                        <input type='hidden' name=table_bis value=$Table></input>
                        <input type='submit'></input>
                    </form>");
                echo("<br/> <h4>rh:taux d'humidité dans l'air, wb:...
                <br/>Le format date est de la forme: AAAA-MM-JJ.</h4>");
                if (isset($_POST["id_thermometre"]))
                    $id_thermometre=$_POST["id_thermometre"];
                if (isset($_POST["heure_rel"]))
                    $heure_rel=$_POST["heure_rel"];
                if (isset($_POST["date_rel"]))
                    $date_rel=$_POST["date_rel"];
                if (isset($_POST["temperature"]))
                    $temperature=$_POST["temperature"];
                if (isset($_POST["rh"]))
                    $rh=$_POST["rh"];
                if (isset($_POST["wb"]))
                    $wb=$_POST["wb"];
                if (isset($_POST["dp"]))
                    $dp=$_POST["dp"];
#               var_dump($_POST);
                $query = $pdo->query("INSERT IGNORE INTO heure_releve Values (\"$heure_rel\"); INSERT IGNORE INTO Date_releve Values (\"$date_rel\"); INSERT INTO Mesurer VALUES (\"$id_thermometre\",\"$heure_rel\",\"$date_rel\",$temperature,$rh,$wb,$dp)");
                echo("\n<h2>La requête créée est 'INSERT IGNORE INTO heure_releve Values (\"$heure_rel\"); INSERT IGNORE INTO Date_releve Values (\"$date_rel\"); INSERT INTO Mesurer VALUES (\"$id_thermometre\",\"$heure_rel\",\"$date_rel\",$temperature,$rh,$wb,$dp)'</h2>");
                break;
            case "Releve_glands":
                echo("<br/> <br/> <h4>Pour ajouter une récolte de glands, vous devez compléter les champs suivants: id_arbre, date_relevé, nombre de glands total, poids de la récolte.</h4>");
                echo("<form method='POST'>
                        <input type='text' placeholder='id_arbre' name=id_arbre></input>
                        <input type='text' placeholder='date_relevé' name=date_rel></input>
                        <input type='text' placeholder='nombre de glands total' name=nbr_glands_total></input>
                        <input type='text' placeholder='poids de la récolte' name=poids_recolte></input>
                        <input type='hidden' name=table_bis value=$Table></input>
                        <input type='submit'></input>
                    </form>");
                echo("<br/> <h4>L'identifiant de l'arbre est déterminé par la première lettre de son essence (P:chêne pédonculé, S:chêne sessile, H:hêtre commun), puis par un nombre.
                <br/>Le format date est de la forme: AAAA-MM-JJ.</h4>");
                if (isset($_POST["id_arbre"]))
                    $id_arbre=$_POST["id_arbre"];
                if (isset($_POST["date_rel"]))
                    $date_rel=$_POST["date_rel"];
                if (isset($_POST["nbr_glands_total"]))
                    $nbr_glands_total=$_POST["nbr_glands_total"];
                if (isset($_POST["poids_recolte"]))
                    $poids_recolte=$_POST["poids_recolte"];
#               var_dump($_POST);
                $query = $pdo->query("INSERT IGNORE INTO Date_releve VALUES (\"$date_rel\");
                                        INSERT INTO Recolter VALUES (\"$id_arbre\",\"$date_rel\",\"$nbr_glands_total\",\"$poids_recolte\")");
                echo("\n<h2>La requête créée est 'INSERT IGNORE INTO Date_releve VALUES (\"$date_rel\");
                INSERT INTO Recolter VALUES (\"$id_arbre\",\"$date_rel\",\"$nbr_glands_total\",\"$poids_recolte\")'</h2>");


                echo("<br/> <br/> <h4>Pour ajouter un relevé houppier, vous devez compléter les champs suivants: id_arbre, date_relevé, indice de fructification, présence de fruits au sol.</h4>");
                echo("<form method='POST'>
                        <input type='text' placeholder='id_arbre' name=id_arbre></input>
                        <input type='text' placeholder='date_relevé' name=date_rel></input>
                        <input type='text' placeholder='indice de fructification' name=indice_fructification></input>
                        <input type='text' placeholder='présence de fruits au sol' name=fruit_sol></input>
                        <input type='hidden' name=table_bis value=$Table></input>
                        <input type='submit'></input>
                    </form>");
                echo("<br/> <br/> <h4>L'identifiant de l'arbre est déterminé par la première lettre de son essence (P:chêne pédonculé, S:chêne sessile, H:hêtre commun), puis par un nombre.
                <br/>Le format date est de la forme: AAAA-MM-JJ.
                <br/>L'indice de fructification est un chiffre compris entre 0 et 4, 0 correspond à un arbre qui produit très peu voir pas dutout, et 4 correspond à une production élevé.
                <br/>Pour la présence de fruit au sol: si oui mettre 1 et sinon mettre 2</h4>.");
                if (isset($_POST["id_arbre"]))
                    $id_arbre=$_POST["id_arbre"];
                if (isset($_POST["date_rel"]))
                    $date_rel=$_POST["date_rel"];
                if (isset($_POST["indice_fructification"]))
                    $indice_fructification=$_POST["indice_fructification"];
                if (isset($_POST["fruit_sol"]))
                    $fruit_sol=$_POST["fruit_sol"];
#               var_dump($_POST);
                $query = $pdo->query("INSERT IGNORE INTO Date_releve VALUES (\"$date_rel\");
                                        INSERT INTO relever_houppier VALUES (\"$id_arbre\",\"$date_rel\",\"$indice_fructification\",\"$fruit_sol\")");
                echo("\n<h2>La requête créée est 'INSERT IGNORE INTO Date_releve VALUES (\"$date_rel\");
                INSERT INTO relever_houppier VALUES (\"$id_arbre\",\"$date_rel\",\"$indice_fructification\",\"$fruit_sol\")'</h2>");


                break;
            case "Meteo":
                echo("<br/> <br/> <h4>Pour ajouter un relevé météo, vous devez compléter les champs suivants: vitesse du vent, température, date.</h4>");
                echo("<form method='POST'>
                        <input type='text' placeholder='vitesse du vent' name=vent></input>
                        <input type='text' placeholder='température' name=temp></input>
                        <input type='text' placeholder='date' name=annee_mois></input>
                        <input type='hidden' name=table_bis value=$Table></input>
                        <input type='submit'></input>
                    </form>");
                echo("<br/> <h4>La vitesse du vent est un nombre entier.
                <br/>La temperature peut être un nombre décimal.
                <br/>Le format date est de la forme: AAAA-MM-JJ.</h4>");
                if (isset($_POST["vent"]))
                    $vent=$_POST["vent"];
                if (isset($_POST["temp"]))
                    $temp=$_POST["temp"];
                if (isset($_POST["annee_mois"]))
                    $annee_mois=$_POST["annee_mois"];
#               var_dump($_POST);
                $query = $pdo->query("SELECT MAX(id_meteo) FROM Date_donnees_externes;");
                    $resultat = $query->fetchAll();
                    foreach ($resultat as $key => $variable){
                        $max = $resultat[$key]['MAX(id_meteo)'];
                    }
                $max=$max+1;
                $query = $pdo->query("INSERT INTO Date_donnees_externes VALUES ($max,\"$annee_mois\");
                INSERT INTO Donnees_externes(vent,temp) VALUES (\"$vent\",\"$temp\");
                INSERT INTO relever_meteo (annee_mois,id_lieu) VALUES (\"$annee_mois\",1)");
                echo("\n <h2>La requête créée est 'INSERT INTO Date_donnees_externes VALUES ($max,\"$annee_mois\");
                INSERT INTO Donnees_externes VALUES (\"$vent\",\"$temp\")'</h2>");

                break;
            case "Comptage_sangliers":
                echo("<br/> <br/> <h4>Pour ajouter un comptage de sanglier, vous devez compléter les champs suivants: année, nombre de sangliers comptés.</h4>");
                echo("<form method='POST'>
                        <input type='text' placeholder='année' name=annee></input>
                        <input type='text' placeholder='nombre de sangliers comptés' name=nb_comptage></input>
                        <input type='hidden' name=table_bis value=$Table></input>
                        <input type='submit'></input>
                    </form>");
                if (isset($_POST["annee"]))
                    $annee=$_POST["annee"];
                if (isset($_POST["nb_comptage"]))
                    $nb_comptage=$_POST["nb_comptage"];
#               var_dump($_POST);
                $query = $pdo->query("INSERT INTO Annee VALUES (\"$annee\"); 
                                    INSERT INTO compter VALUES (\"$annee\",1,$nb_comptage)");
                echo("\n <h2>La requête créée est 'INSERT INTO Annee VALUES (\"$annee\"); INSERT INTO compter VALUES (\"$annee\",1,$nb_comptage)'</h2>");

                break;
            case "Prelevement_sangliers":
                echo("<br/> <br/> <h4>Pour ajouter un comptage de sanglier, vous devez compléter les champs suivants: période, nombre de sangliers prélevés.</h4>");
                echo("<form method='POST'>
                        <input type='text' placeholder='période' name=periode></input>
                        <input type='text' placeholder='nombre de sangliers prélevés' name=nb_prelevement></input>
                        <input type='hidden' name=table_bis value=$Table></input>
                        <input type='submit'></input>
                    </form>");
                echo("<br/> <h4>La période est de la forme AAAA-AAAA, ex 2014-2015</h4>");
                if (isset($_POST["periode"]))
                    $periode=$_POST["periode"];
                if (isset($_POST["nb_prelevement"]))
                    $nb_prelevement=$_POST["nb_prelevement"];
#               var_dump($_POST);
                $query = $pdo->query("INSERT INTO Periode VALUES (\"$periode\"); 
                                    INSERT INTO prelever VALUES (\"$periode\",1,$nb_prelevement)");
                echo("\n<h2>La requête créée est 'INSERT INTO prelever VALUES (\"$periode\",1,$nb_prelevement)</h2>");

                break;

         }
        ?>
    </body>
</html>