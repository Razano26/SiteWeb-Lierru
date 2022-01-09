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
        echo("<h1>Partie SUPPRIMER.<br/> <h4>On peut SUPPRIMER une ligne dans plusieurs tables de la base de données, il suffit de choisir la thématique concernée dans le formulaire ci-dessous :  </h1></h4>");

        if (isset($_POST["Table"]))   
            $Table=$_POST["Table"];

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
                echo("<br/> <br/> <h4>Choisissez l'arbre que vous voulez supprimer : </h4>");
                $query = $pdo->query("SELECT * from Arbre ");
                $resultat = $query->fetchAll();
                echo("<form method='POST'><select name='arbre_choisi'>");
                foreach ($resultat as $key => $variable){
                    echo("<option value='".$resultat[$key]['id_arbre']."'>nom de l'arbre : ".$resultat[$key]['id_arbre'].", essence de l'arbre : ".$resultat[$key]['essence'].", type de l'arbre : ".$resultat[$key]['type'].", groupement de l'arbre : ".$resultat[$key]['id_groupement']."</option>");

                } 
                echo("</select>
                      <input type='hidden' name=table_bis value=$Table>
                      </input>
                      <input type='submit' value='supprimer'>
                      </input>
                      </form>");
                
                if (isset($_POST["arbre_choisi"]))
                    $arbre_choisi=$_POST["arbre_choisi"];

                $query = $pdo->query("DELETE FROM Arbre WHERE id_arbre=\"$arbre_choisi\";
                                        DELETE FROM Coordonnee WHERE id_position=\"$arbre_choisi\"");
                echo("\n<h2>La requête créée est 'DELETE FROM Arbre WHERE id_arbre=\"$arbre_choisi\";
                                                DELETE FROM Coordonnee WHERE id_position=\"$arbre_choisi\"'</h2>");
                break;
            case "Thermometre":
                echo("<br/> <br/> <h4>Choisissez le thermomètre que vous voulez supprimer : ");
                $query = $pdo->query("SELECT * from Thermometre ");
                $resultat = $query->fetchAll();
                echo("<form method='POST'><select name='thermometre_choisi'>");
                foreach ($resultat as $key => $variable){
                    echo("<option value='".$resultat[$key]['id_thermometre']."'>nom du thermometre : ".$resultat[$key]['id_thermometre'].", groupement de l'arbre : ".$resultat[$key]['id_groupement']."</option>");
    
                } 
                echo("</select>
                        <input type='hidden' name=table_bis value=$Table>
                        </input>
                        <input type='submit' value='supprimer'>
                        </input>
                        </form>");
                    
                if (isset($_POST["thermometre_choisi"]))
                    $thermometre_choisi=$_POST["thermometre_choisi"];
    
                $query = $pdo->query("DELETE FROM Thermometre WHERE id_thermometre=\"$thermometre_choisi\";
                                            DELETE FROM Coordonnee WHERE id_position=\"$thermometre_choisi\"");
                echo("\n<h2>La requête créée est 'DELETE FROM Arbre WHERE id_thermometre=\"$thermometre_choisi\";
                                                    DELETE FROM Coordonnee WHERE id_position=\"$thermometre_choisi\"'</h2>");



                echo("<br/> <br/> <h4>Choisissez le relevé de température que vous voulez supprimer : </h4>");
                $query = $pdo->query("SELECT id_thermometre from Thermometre ");
                $resultat1 = $query->fetchAll();

                $query = $pdo->query("SELECT heure_rel FROM heure_releve ");
                $resultat2 = $query->fetchAll();

                $query = $pdo->query("SELECT date_rel FROM Date_releve ");
                $resultat3 = $query->fetchAll();
                 
                echo("<form method='POST'><select name='t_choisi'>");
                foreach ($resultat1 as $key => $variable){
                    echo("<option value='".$resultat1[$key]['id_thermometre']."'>nom du thermometre : ".$resultat1[$key]['id_thermometre']."</option>");
                } 
                echo("</select>");

                echo("<select name='h_choisi'>");
                foreach ($resultat2 as $key => $variable){
                    echo("<option value='".$resultat2[$key]['heure_rel']."'>heure du relevé : ".$resultat2[$key]['heure_rel']."</option>");                        
                }  
                echo("</select>");       
                        

                echo("<select name='d_choisi'>");
                foreach ($resultat3 as $key => $variable){
                    echo("<option value='".$resultat3[$key]['date_rel']."'>date du relevé : ".$resultat3[$key]['date_rel']."</option>");                        
                }  
                echo("</select>
                        <input type='hidden' name=table_bis value=$Table>
                        </input>
                        <input type='submit' value='supprimer'>
                        </input>
                        </form>");  

                if (isset($_POST["t_choisi"]))
                    $t_choisi=$_POST["t_choisi"];
                if (isset($_POST["h_choisi"]))
                    $h_choisi=$_POST["h_choisi"];
                if (isset($_POST["d_choisi"]))
                    $d_choisi=$_POST["d_choisi"];    

                $query = $pdo->query("DELETE FROM Mesurer WHERE id_thermometre=\"$t_choisi\" and heure_rel=\"$h_choisi\" and date_rel=\"$d_choisi\"");
                echo("\n<h2>La requête créée est 'DELETE FROM Mesurer WHERE id_thermometre=\"$t_choisi\" and heure_rel=\"$h_choisi\" and date_rel=\"$d_choisi\"'</h2>");

                break;
            case "Releve_glands":
                
                echo("<br/> <br/> <h4>Choisissez un arbre et une date pour une récolte que vous voulez supprimer : </h4>");
                $query = $pdo->query("SELECT id_arbre from Arbre ");
                $resultat1 = $query->fetchAll();
                
                $query = $pdo->query("SELECT date_rel FROM Date_releve ");
                $resultat2 = $query->fetchAll();
                
                echo("<form method='POST'><select name='a_choisi'>");
                foreach ($resultat1 as $key => $variable){
                    echo("<option value='".$resultat1[$key]['id_arbre']."'>nom de l'arbre : ".$resultat1[$key]['id_arbre']."</option>");
                } 
                echo("</select>");
    
                echo("<select name='d_choisi'>");
                foreach ($resultat2 as $key => $variable){
                    echo("<option value='".$resultat2[$key]['date_rel']."'>date du relevé : ".$resultat2[$key]['date_rel']."</option>");                        
                }  
                echo("</select>
                        <input type='hidden' name=table_bis value=$Table>
                        </input>
                        <input type='submit' value='supprimer'>
                        </input>
                        </form>");  

                if (isset($_POST["a_choisi"]))
                    $a_choisi=$_POST["a_choisi"];
                if (isset($_POST["d_choisi"]))
                    $d_choisi=$_POST["d_choisi"];    

                $query = $pdo->query("DELETE FROM Recolter WHERE id_arbre=\"$a_choisi\" and date_rel=\"$d_choisi\"");
                echo("\n<h2>La requête créée est 'DELETE FROM Recolter WHERE id_arbre=\"$a_choisi\" and date_rel=\"$d_choisi\"'");
                

                echo("<br/> <br/> <h4>Choisissez un arbre et une date pour un relevé houppier que vous voulez supprimer : </h4>");
                $query = $pdo->query("SELECT id_arbre from Arbre ");
                $resultat1 = $query->fetchAll();

                $query = $pdo->query("SELECT date_rel FROM Date_releve ");
                $resultat2 = $query->fetchAll();
                 
                echo("<form method='POST'><select name='arbre_choisi'>");
                foreach ($resultat1 as $key => $variable){
                    echo("<option value='".$resultat1[$key]['id_arbre']."'>nom de l'arbre : ".$resultat1[$key]['id_arbre']."</option>");
                } 
                echo("</select>");
    
                echo("<select name='date_choisi'>");
                foreach ($resultat2 as $key => $variable){
                    echo("<option value='".$resultat2[$key]['date_rel']."'>date du relevé : ".$resultat2[$key]['date_rel']."</option>");                        
                }  
                echo("</select>
                        <input type='hidden' name=table_bis value=$Table>
                        </input>
                        <input type='submit' value='supprimer'>
                        </input>
                        </form>");  

                if (isset($_POST["arbre_choisi"]))
                    $arbre_choisi=$_POST["arbre_choisi"];
                if (isset($_POST["date_choisi"]))
                    $date_choisi=$_POST["date_choisi"];    

                $query = $pdo->query("DELETE FROM relever_houppier WHERE id_arbre=\"$arbre_choisi\" and date_rel=\"$date_choisi\"");
                echo("\n<h2>La requête créée est 'DELETE FROM relever_houppier WHERE id_arbre=\"$arbre_choisi\" and date_rel=\"$date_choisi\"'</h2>");
               
                break;
            case "Meteo":

                echo("<br/> <br/> <h4>Choisissez le relevé météo que vous voulez supprimer : </h4>");
                $query = $pdo->query("SELECT * from Donnees_externes ");
                $resultat = $query->fetchAll();
                echo("<form method='POST'><select name='m_choisi'>");
                foreach ($resultat as $key => $variable){
                    echo("<option value='".$resultat[$key]['id_meteo']."'>identifiant : ".$resultat[$key]['id_meteo'].", vitesse du vent : ".$resultat[$key]['vent'].", température : ".$resultat[$key]['temp']."</option>");

                } 
                echo("</select>
                      <input type='hidden' name=table_bis value=$Table>
                      </input>
                      <input type='submit' value='supprimer'>
                      </input>
                      </form>");
                
                if (isset($_POST["m_choisi"]))
                    $m_choisi=$_POST["m_choisi"];

                $query = $pdo->query("DELETE FROM relever_meteo WHERE id_meteo=$m_choisi; DELETE FROM Donnees_externes WHERE id_meteo=$m_choisi");
                echo("\n<h2>La requête créée est 'DELETE FROM relever_meteo WHERE id_meteo=$m_choisi; DELETE FROM Donnees_externes WHERE id_meteo=$m_choisi'</h2>");
                break;
            case "Comptage_sangliers":

                echo("<br/> <br/> <h4>Choisissez le comptage de sangliers que vous voulez supprimer : </h4>");
                $query = $pdo->query("SELECT * from compter ");
                $resultat = $query->fetchAll();
                echo("<form method='POST'><select name='annee_choisie'>");
                foreach ($resultat as $key => $variable){
                    echo("<option value='".$resultat[$key]['annee_comptage']."'>année de comptage : ".$resultat[$key]['annee_comptage'].", nombre de sangliers comptés : ".$resultat[$key]['comptage_sanglier']."</option>");

                } 
                echo("</select>
                      <input type='hidden' name=table_bis value=$Table>
                      </input>
                      <input type='submit' value='supprimer'>
                      </input>
                      </form>");
                
                if (isset($_POST["annee_choisie"]))
                    $annee_choisie=$_POST["annee_choisie"];

                $query = $pdo->query("DELETE FROM compter WHERE annee_comptage=$annee_choisie");
                echo("\n<h2>La requête créée est 'DELETE FROM compter WHERE annee_comptage=$annee_choisie'</h2>");

                break;
            case "Prelevement_sangliers":

                echo("<br/> <br/> <h4>Choisissez le prélèvement de sangliers que vous voulez supprimer : </h4>");
                $query = $pdo->query("SELECT * from prelever ");
                $resultat = $query->fetchAll();
                echo("<form method='POST'><select name='periode_choisie'>");
                foreach ($resultat as $key => $variable){
                    echo("<option value='".$resultat[$key]['periode']."'>période de prélèvement : ".$resultat[$key]['periode'].", nombre de sangliers prélevés : ".$resultat[$key]['prelevement_sanglier']."</option>");

                } 
                echo("</select>
                      <input type='hidden' name=table_bis value=$Table>
                      </input>
                      <input type='submit' value='supprimer'>
                      </input>
                      </form>");
                
                if (isset($_POST["periode_choisie"]))
                    $periode_choisie=$_POST["periode_choisie"];

                $query = $pdo->query("DELETE FROM prelever WHERE periode=\"$periode_choisie\"");
                echo("\n<h2>La requête créée est 'DELETE FROM prelever WHERE periode=\"$periode_choisie\"'</h2>");

                break;
            }


        ?>


    </body>
</html>