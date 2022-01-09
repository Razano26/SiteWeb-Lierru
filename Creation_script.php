<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Crée les requêtes SQL</title>
    <link rel="stylesheet" href="style/stylepage.css">
</head>
    <body>
        <?php
            // Fichiers sources CSV analysés pour constituer les requêtes
                $source02="files/AUTOMATISE_GPS_thermometres_arbres.csv";
                $source03="files/AUTOMATISE_Relevés_thermometres.csv";
                $source04="files/AUTOMATISE_codes_arbres.txt";
                $source05="files/MANUEL_Arbres_releves_fructification.csv";
                $source06="files/MANUEL_Sangliers_comptage.csv";
                $source07="files/MANUEL_Sangliers_prelevements.csv";
                $source08="files/Temperature+vent.csv";

            // Fichiers de requêtes au format texte en SQL à générer
                $SQL01="script/SQL01_Création_Manuelle_des_données.sql";
                $SQL02="script/SQL02_AUTOMATISE_GPS_thermometres_arbres.sql";
                $SQL03="script/SQL03_AUTOMATISE_Relevés_thermometres.sql";
                $SQL03_5="script/SQL03_5_AUTOMATISE_heure_date.sql";
                $SQL04="script/SQL04_AUTOMATISE_codes_arbres.sql";
                $SQL05="script/SQL05_MANUEL_Arbres_releves_fructification.sql";
                $SQL06="script/SQL06_MANUEL_Sangliers_comptage.sql";
                $SQL07="script/SQL07_MANUEL_Sangliers_prelevements.sql";
                $SQL08="script/SQL08_AUTOMATISE_Donnee_externe.sql";

                $sep=";";

                echo "<h1><center>Création des fichiers de requêtes SQL pour constituer la base de données</center></h1>";
            /////////////////////////////////////////////////////////////////////
            ///// Création Manuelle
            ///// --> TABLE DOMAINE
            ///// --> TABLE Groupement_forestier
            /////////////////////////////////////////////////////////////////////

            $ecritSQL = fopen( $SQL01, "w");

            $sqlcomment="-- CREATION Manuelle des données\r\n";

            echo "<span>",$sqlcomment,"</span><br/>";

            $sqlcomment="-- --> TABLE Domaine\r\n";
            echo $sqlcomment,"<br/>";

            $sqlcomment="-- --> TABLE Groupement_forestier\r\n";
            echo $sqlcomment,"<br/>";
            echo "<br/>";

            $sql="INSERT INTO Domaine(id_domaine,nom_domaine) VALUES(1,'Lierru');\r\n";
            fwrite($ecritSQL,$sql);

            $sql="INSERT INTO Groupement_forestier(id_groupement,nom_groupement,id_domaine) VALUES('E','Groupement de l''Etang',1);\r\n";
            fwrite($ecritSQL,$sql);

            $sql="INSERT INTO Groupement_forestier(id_groupement,nom_groupement,id_domaine) VALUES('B','Groupement du Bénitier',1);\r\n";
            fwrite($ecritSQL,$sql);

            $sql="INSERT INTO Groupement_forestier(id_groupement,nom_groupement,id_domaine) VALUES('D','Groupement du Haras (Doré) et de la Bourgeraie',1);\r\n";
            fwrite($ecritSQL,$sql);

            $sql="INSERT INTO Groupement_forestier(id_groupement,nom_groupement,id_domaine) VALUES('P','Groupement du Lierru',1);\r\n";
            fwrite($ecritSQL,$sql);

            echo "<h2>Nombre de requêtes créées: <span>5</span></h2>";
            echo "<h2>Fichier de sortie créé: <span>$SQL01</span></h2><br/>";

            fclose($ecritSQL);

            echo "<hr/>";

            /////////////////////////////////////////////////////////////////////
            ///// Fichier de données: AUTOMATISE_GPS_thermometres_arbres.csv
            ///// --> TABLE Coordonnee
            ///// --> TABLE ARBRE
            ///// --> TABLE THERMOMETRE
            /////////////////////////////////////////////////////////////////////

            $ecritSQL = fopen($SQL02 , "w");

            echo "<br/><br/>";

            $sqlcomment="-- FICHIER traité: $source02\r\n";

            echo "<span>",$sqlcomment,"</span><br/>";

            $sqlcomment="-- --> TABLE POINT\r\n";

            echo $sqlcomment,"<br/>";

            $sqlcomment="-- --> TABLE ARBRE\r\n";

            echo $sqlcomment,"<br/>";

            $sqlcomment="-- --> TABLE THERMOMETRE\r\n";

            echo $sqlcomment,"<br/>";
            echo "<br/>";

            $litGPS = fopen($source02 , "r");
            $entete = fgetcsv($litGPS, 0, $sep);

            $cpt=0;
            $req=0;
            while (($data = fgetcsv($litGPS, 0, $sep)) !== FALSE) {
                $cpt++;
                $id_group_forestier=$data[0];
                $GPS_X=$data[1];
                $GPS_Y=$data[2];
                $id_point=$data[3];
                $type=$data[5];
            
            
                if ($id_point[0]=='T')
                    $id_point="LIERRU";
            
                $sql="INSERT INTO Coordonnee(id_position,latitude,longitude) VALUES('$id_point','$GPS_Y','$GPS_X');\r\n";
                fwrite($ecritSQL,$sql);
                $req++;

                if ($id_point!='LIERRU'){
                    
                    switch($id_point[0]){
                        case 'H': $essence='Hêtre commun'; $typearbre=0; break;
                        case 'S': $essence='Chêne sessile';$typearbre=27;  break;
                        case 'P': $essence='Chêne pédonculé'; $typearbre=29; break;
                    }
                    $id_arbre=$id_point; 
            
                    $sql="INSERT INTO Arbre(id_arbre,essence,type,id_groupement,id_position) VALUES('$id_arbre','$essence','$typearbre','$id_group_forestier','$id_point');\r\n";
                    fwrite($ecritSQL,$sql);
                    $req++;
                }	

                if (($data[5]==1)||($data[5]==18)){
                    $id_thermometre=$id_point;  
                    
                    $sql="INSERT INTO Thermometre(id_thermometre,id_groupement,id_position) VALUES('$id_thermometre','$id_group_forestier','$id_point');\r\n";
                    fwrite($ecritSQL,$sql);
                    $req++;
                }
                elseif (($data[5]!=0)&&($data[5]!=27)&&($data[5]!=29)){
                    die("Erreur dans le fichier, type inconnu: ".$data[5]." en ligne $id_point"); 
                }
                
                //echo "<br/>";
                
            }

            echo "<h2>Nombre de lignes traitées: <span>$cpt</span></h2>";
            echo "<h2>Nombre de requêtes créées: <span>$req</span></h2>";
            echo "<h2>Fichier de sortie créé: <span>$SQL02</span></h2><br/>";
            
            fclose($litGPS);
            fclose($ecritSQL);
            
            
            echo "<hr/>";

            /////////////////////////////////////////////////////////////////////
            ///// Fichier de données: AUTOMATISE_Relevés_thermometres.csv
            ///// --> TABLE heure_releve + date
            ///// --> TABLE Mesurer
            /////////////////////////////////////////////////////////////////////

            $ecritSQL = fopen($SQL03_5 , "w");

            echo "<br/><br/>";

            $sqlcomment="-- FICHIER traité: $source03\r\n";

            echo "<span>",$sqlcomment,"</span><br/>";

            $sqlcomment="-- --> TABLE heure_releve\r\n";

            echo $sqlcomment,"<br/>";
            echo "<br/>";

            $litThermo = fopen($source03,"r");
            $entete = fgetcsv($litThermo, 0, $sep);

            $cpt=0;
            $req=0;
            $date=array();
            $heure=array();
            while (($data = fgetcsv($litThermo, 0, $sep)) !== FALSE) {
                $cpt++;
                $heure_rel=$data[6];
                $date_rel=$data[5];
                array_push($date,$date_rel);
                array_push($heure,$heure_rel);
                
            }
            $date=array_unique($date);
            $heure=array_unique($heure);

            

            echo "<h2>Nombre de lignes traitées: <span>$cpt</span></h2>";
            echo "<h2>Nombre de requêtes créées: <span>$req</span></h2>";
            echo "<h2>Fichier de sortie créé: <span>$SQL03_5</span></h2><br/>";

            fclose($litThermo);
            fclose($ecritSQL);

            echo "<hr/>";            




            $ecritSQL = fopen($SQL03 , "w");

            echo "<br/><br/>";

            $sqlcomment="-- FICHIER traité: $source03\r\n";

            echo "<span>",$sqlcomment,"</span><br/>";

            $sqlcomment="-- --> TABLE Mesurer\r\n";

            echo $sqlcomment,"<br/>";
            echo "<br/>";

            $litThermo = fopen($source03,"r");
            $entete = fgetcsv($litThermo, 0, $sep);

            $cpt=0;
            $req=0;
            while (($data = fgetcsv($litThermo, 0, $sep)) !== FALSE) {
                $cpt++;
                $heure_rel=$data[6];
                $date_rel=$data[5];
                $id_thermometre=$data[0];
                $Temp=$data[1];
                $RH=$data[2];
                $WB=$data[3];
                $DP=$data[4];
                
                $sql="INSERT INTO Mesurer(heure_rel,date_rel,id_thermometre,temperature,rh,wb,dp) VALUES('$heure_rel','$date_rel','$id_thermometre',$Temp,$RH,$WB,$DP);\r\n";
                fwrite($ecritSQL,$sql);
                $req++;
                //echo $sql,"<br/>";
            }

            echo "<h2>Nombre de lignes traitées: <span>$cpt</span></h2>";
            echo "<h2>Nombre de requêtes créées: <span>$req</span></h2>";
            echo "<h2>Fichier de sortie créé: <span>$SQL03</span></h2><br/>";

            fclose($litThermo);
            fclose($ecritSQL);

            echo "<hr/>";

            /////////////////////////////////////////////////////////////////////
            ///// Fichier de données: AUTOMATISE_codes_arbres.txt
            ///// --> TABLE CARRE
            /////////////////////////////////////////////////////////////////////
            $ecritSQL = fopen($SQL04,"w");

            echo "<br/><br/>";
            
            $sqlcomment="-- FICHIER traité: $source04\r\n";

            echo "<span>",$sqlcomment,"</span><br/>";
            
            $sqlcomment="-- --> TABLE Carree\r\n";

            echo $sqlcomment,"<br/>";
            
            $litcodearbres = fopen($source04,"r");
            
            $cpt=0;
            $req=0;
            while(!feof($litcodearbres)){ 
                $id_arbre=trim(fgets($litcodearbres));
                $cpt++;
                $designation=$id_arbre."_N";
                $sql="INSERT INTO Carree(designation,orientation) VALUES('$designation','Nord');\r\n";
                fwrite($ecritSQL,$sql);
                $req++;
                //echo $sql,"<br/>";
                $designation=$id_arbre."_S";
                $sql="INSERT INTO Carree(designation,orientation) VALUES('$designation','Sud');\r\n";
                fwrite($ecritSQL,$sql);
                $req++;
                //echo $sql,"<br/>";
                $designation=$id_arbre."_E";
                $sql="INSERT INTO Carree(designation,orientation) VALUES('$designation','Est');\r\n";
                fwrite($ecritSQL,$sql);
                $req++;
                //echo $sql,"<br/>";
                $designation=$id_arbre."_O";
                $sql="INSERT INTO Carree(designation,orientation) VALUES('$designation','Ouest');\r\n";
                fwrite($ecritSQL,$sql);
                $req++;
                //echo $sql,"<br/>";
            }
                
            echo "<h2>Nombre de lignes traitées: <span>$cpt</span></h2>";
            echo "<h2>Nombre de requêtes créées: <span>$req</span></h2>";
            echo "<h2>Fichier de sortie créé: <span>$SQL04</span></h2><br/>";
            
            fclose($litcodearbres);
            fclose($ecritSQL);
            
            echo "<hr/>";
            /////////////////////////////////////////////////////////////////////
            ///// Fichier de données: MANUEL_Arbres_releves_fructification.csv
            ///// --> TABLE relever_houppier
            ///// --> TABLE relever_sol
            ///// --> TABLE Recolter
            /////////////////////////////////////////////////////////////////////

            $ecritSQL = fopen($SQL03_5 , "w");

            echo "<br/><br/>";

            $litThermo = fopen($source05,"r");
            $entete = fgetcsv($litThermo, 0, $sep);

            $cpt=0;
            $req=0;
            while (($data = fgetcsv($litThermo, 0, $sep)) !== FALSE) {
                $cpt++;
                $date_rel2=$data[5];
                $date_rel=$data[2];
                array_push($date,$date_rel);
                array_push($date,$date_rel2);
                
            }
            $date=array_unique($date);
            $heure=array_unique($heure);



            foreach ($date as $valeur) {
                $sql="INSERT INTO Date_releve(date_rel) VALUES('$valeur');\r\n";
                fwrite($ecritSQL,$sql);
                $req++;
            }
            foreach ($heure as $valeur) {
                $sql="INSERT INTO heure_releve(heure_rel) VALUES('$valeur');\r\n";
                fwrite($ecritSQL,$sql);
                $req++;
            }

            echo "<h2>Nombre de lignes traitées: <span>$cpt</span></h2>";
            echo "<h2>Nombre de requêtes créées: <span>$req</span></h2>";
            echo "<h2>Fichier de sortie créé: <span>$SQL03_5</span></h2><br/>";

            fclose($litThermo);
            fclose($ecritSQL);

            echo "<hr/>";




            $ecritSQL = fopen($SQL05,"w");

            echo "<br/><br/>";

            $sqlcomment="-- FICHIER traité: $source05\r\n";

            echo "<span>",$sqlcomment,"</span><br/>";

            $sqlcomment="-- --> TABLE relever_houppier\r\n";

            echo $sqlcomment,"<br/>";

            $sqlcomment="-- --> TABLE relever_sol\r\n";

            echo $sqlcomment,"<br/>";

            $sqlcomment="-- --> TABLE Recolter\r\n";

            echo $sqlcomment,"<br/>";

            echo "<br/>";

            $litThermo = fopen($source05,"r");
            $entete = fgetcsv($litThermo, 0, $sep);

            $cpt=0;
            $req=0;
            while (($data = fgetcsv($litThermo, 0, $sep)) !== FALSE) {
                
                    $cpt++;
                    $date_rel=$data[2];
                    $id_arbre=$data[1];
                    $indice_fructification=$data[3];
                    $fruits_sol=$data[4];
                    
                    // choisi par facilité, sinon code arbitraire à prendre
                    //$designation=$id_arbre suivi de "_N" ou "_S" ou...;  
                    
                    $date_relever_sol=$data[5];
                    
                    // Si toutes les mesures contiennent quelque chose alors on ajoute le relevé houppier, sinon pas
                    if (($data[3]!="")&&($data[4]!="")){
                        
                        $sql="INSERT INTO relever_houppier(date_rel,id_arbre,indice_fructification,fruit_sol) VALUES('$date_rel','$id_arbre',$indice_fructification,$fruits_sol);\r\n";
                        fwrite($ecritSQL,$sql);
                        $req++;
                        //echo $sql,"<br/>";
                    }
                    
                    // Si l'un des quadrats contient quelque chose alors on ajoute le relevé de sol, sinon pas
                    if (($data[6]!="")||($data[7]!="")||($data[8]!="")||($data[9]!="")){
                        $data[6]=$data[6]!=""?$data[6]:0;
                        $data[7]=$data[7]!=""?$data[7]:0;
                        $data[8]=$data[8]!=""?$data[8]:0;
                        $data[9]=$data[9]!=""?$data[9]:0;
                    
                        $designation=$id_arbre."_N";
                        $nombre_fruits=$data[6];
                        $sql="INSERT INTO relever_sol(date_rel,designation,id_arbre,nbr_glands) VALUES('$date_relever_sol','$designation','$id_arbre',$nombre_fruits);\r\n";
                        fwrite($ecritSQL,$sql);
                        $req++;
                        //echo $sql,"<br/>";
                        
                        $designation=$id_arbre."_S";
                        $nombre_fruits=$data[7];
                        $sql="INSERT INTO relever_sol(date_rel,designation,id_arbre,nbr_glands) VALUES('$date_relever_sol','$designation','$id_arbre',$nombre_fruits);\r\n";
                        fwrite($ecritSQL,$sql);
                        $req++;
                        //echo $sql,"<br/>";
                        
                        $designation=$id_arbre."_E";
                        $nombre_fruits=$data[8];
                        $sql="INSERT INTO relever_sol(date_rel,designation,id_arbre,nbr_glands) VALUES('$date_relever_sol','$designation','$id_arbre',$nombre_fruits);\r\n";
                        fwrite($ecritSQL,$sql);
                        $req++;
                        //echo $sql,"<br/>";
                        
                        $designation=$id_arbre."_O";
                        $nombre_fruits=$data[9];
                        $sql="INSERT INTO relever_sol(date_rel,designation,id_arbre,nbr_glands) VALUES('$date_relever_sol','$designation','$id_arbre',$nombre_fruits);\r\n";
                        fwrite($ecritSQL,$sql);
                        $req++;
                        //echo $sql,"<br/>";

                        $poids=$data[11];
                        $recolte=$data[10];
                        $sql="INSERT INTO Recolter(date_rel,id_arbre,poids_recolte,nbr_glands_total) VALUES('$date_relever_sol','$id_arbre',$poids,$recolte);\r\n";
                        fwrite($ecritSQL,$sql);
                        $req++;
                        //echo $sql,"<br/>";
                    }
            }

            echo "<h2>Nombre de lignes traitées: <span>$cpt</span></h2>";
            echo "<h2>Nombre de requêtes créées: <span>$req</span></h2>";
            echo "<h2>Fichier de sortie créé: <span>$SQL05</span></h2><br/>";

            fclose($litThermo);
            fclose($ecritSQL);

            echo "<hr/>";
            /////////////////////////////////////////////////////////////////////
            ///// Fichier de données: MANUEL_Sangliers_comptage.csv
            ///// --> TABLE Tranche_age
            ///// --> TABLE compter
            ///// --> TABLE compter_details
            /////////////////////////////////////////////////////////////////////





            $ecritSQL = fopen($SQL06,"w");

            echo "<br/><br/>";

            $sqlcomment="-- FICHIER traité: $source06\r\n";

            echo "<span>",$sqlcomment,"</span><br/>";


            $sqlcomment="-- --> TABLE Tranche_age\r\n";

            echo $sqlcomment,"<br/>";

            $sqlcomment="-- --> TABLE compter\r\n";

            echo $sqlcomment,"<br/>";

            $sqlcomment="-- --> TABLE compter_details\r\n";

            echo $sqlcomment,"<br/>";

            echo "<br/>";

            $litSangliersCpt = fopen($source06,"r");
            $entete = fgetcsv($litSangliersCpt, 0, $sep);
            $req=0;

            // Insertion des identifiants provisoires de tranche d'âge 
            // en attendant de nouvelles donnnées
            // Appelations données selon âge provenant de:
            // https://fr.wikipedia.org/wiki/Sanglier
            // https://gourymoulesetbaucels.blogspot.com/2014/10/comment-evaluer-lage-dun-sanglier.html
            // Début:
            $sql="INSERT INTO Tranche_age(tranche_age,description) VALUES('0-6 mois','Marcassin');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO Tranche_age(tranche_age,description) VALUES('6-12 mois','Bête rousse');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO Tranche_age(tranche_age,description) VALUES('1-2 ans','Bête noire');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO Tranche_age(tranche_age,description) VALUES('2-3 ans','Ragot');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO Tranche_age(tranche_age,description) VALUES('3-4 ans','Tiers-ans');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO Tranche_age(tranche_age,description) VALUES('4-5 ans','Quartanier');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO Tranche_age(tranche_age,description) VALUES('6-7 ans','Vieux sanglier');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO Tranche_age(tranche_age,description) VALUES('>7 ans','Grand vieux sanglier');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            // Celui-là c'est pour aller avec nos données qui ne comportent pas d'âge actuellement
            $sql="INSERT INTO Tranche_age(tranche_age,description) VALUES('inc','Tranche âge inconnue');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;
            // Fin

            $cpt=0;

            while (($data = fgetcsv($litSangliersCpt, 0, $sep)) !== FALSE) {
                
                $cpt++;
                $date_rel=$data[0];
                $comptage=$data[1];

                $sql="INSERT INTO Annee(annee_comptage) VALUES('$date_rel');\r\n";
                fwrite($ecritSQL,$sql);
                $req++;


                $sql="INSERT INTO compter(id_domaine,annee_comptage,comptage_sanglier) VALUES(1,'$date_rel',$comptage);\r\n";
                fwrite($ecritSQL,$sql);
                $req++;
                //echo $sql,"<br/>";
                
                // La tranche d'âge est inconnue donc on fait ainsi pour le moment
                $sql="INSERT INTO compter_details(id_domaine,annee_comptage,tranche_age,comptage_det) VALUES(1,'$date_rel','inc',$comptage);\r\n";
                fwrite($ecritSQL,$sql);
                $req++;
                //echo $sql,"<br/>";
                
            }

            echo "<h2>Nombre de lignes traitées: <span>$cpt</span></h2>";
            echo "<h2>Nombre de requêtes créées: <span>$req</span></h2>";
            echo "<h2>Fichier de sortie créé: <span>$SQL06</span></h2><br/>";

            fclose($litSangliersCpt);
            fclose($ecritSQL);

            echo "<hr/>";

            /////////////////////////////////////////////////////////////////////
            ///// Fichier de données: MANUEL_Sangliers_prelevements.csv
            ///// --> TABLE age
            ///// --> TABLE prelever
            ///// --> TABLE sexe
            ///// --> TABLE prelever_details
            /////////////////////////////////////////////////////////////////////

            $ecritSQL = fopen($SQL07,"w");

            echo "<br/><br/>";

            $sqlcomment="-- FICHIER traité: $source07\r\n";

            echo "<span>",$sqlcomment,"</span><br/>";


            $sqlcomment="-- --> TABLE age\r\n";

            echo $sqlcomment,"<br/>";

            $sqlcomment="-- --> TABLE prelever\r\n";

            echo $sqlcomment,"<br/>";

            $sqlcomment="-- --> TABLE sexe\r\n";

            echo $sqlcomment,"<br/>";

            $sqlcomment="-- --> TABLE prelever_details\r\n";

            echo $sqlcomment,"<br/>";

            echo "<br/>";

            $litSangliersPrlvt = fopen($source07,"r");
            $entete = fgetcsv($litSangliersPrlvt, 0, $sep);
            $req=0;


            $sql="INSERT INTO sexe(sexe_prelevement) VALUES('Femelle');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO sexe(sexe_prelevement) VALUES('Mâle');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO sexe(sexe_prelevement) VALUES('Inconnu');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            // Insertion d'exemples d'âges
            // en attendant de nouvelles donnnées utilisant les données suivantes:
            // Estimation des âges de sangliers par leur dentition: 
            // http://www.wildlifeandman.be/docs/Fiche_Age_sanglier_complexe.pdf
            // https://www.passionlachasse.com/t26835-estimation-age-sanglier


            $sql="INSERT INTO age(age,description) VALUES(0,'Naissance');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO age(age,description) VALUES(1,'1 mois');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO age(age,description) VALUES(2,'2-4 mois');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO age(age,description) VALUES(3,'5-6 mois');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO age(age,description) VALUES(4,'7-11 mois');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO age(age,description) VALUES(5,'12-14 mois');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO age(age,description) VALUES(6,'14-18 mois');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO age(age,description) VALUES(7,'19-22 mois');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO age(age,description) VALUES(8,'22-24 mois');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO age(age,description) VALUES(9,'24-36 mois');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO age(age,description) VALUES(10,'3-5 ans');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO age(age,description) VALUES(11,'5-8 ans');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO age(age,description) VALUES(12,'8-10 ans');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            $sql="INSERT INTO age(age,description) VALUES(13,'>10 ans');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;

            // Celui-là c'est pour aller avec nos données qui ne comportent pas d'âge actuellement
            $sql="INSERT INTO age(age,description) VALUES(100,'Age inconnu');\r\n";
            fwrite($ecritSQL,$sql);
            $req++;
            // Fin

            $cpt=0;
            $req=0;
            while (($data = fgetcsv($litSangliersPrlvt, 0, $sep)) !== FALSE) {
                
                $cpt++;
                $date_rel=$data[0];
                $prelevement=$data[1];

                $sql="INSERT INTO Periode(periode) VALUES('$date_rel');\r\n";
                fwrite($ecritSQL,$sql);
                $req++;

                $sql="INSERT INTO prelever(id_domaine,periode,prelevement_sanglier) VALUES(1,'$date_rel',$prelevement);\r\n";
                fwrite($ecritSQL,$sql);
                $req++;
                //echo $sql,"<br/>";
                
                // L'âge est inconnu donc on fait ainsi pour le moment
                $sql="INSERT INTO prelever_details(id_domaine,periode,age,prelevement_det,sexe_prelevement) VALUES(1,'$date_rel',100,$prelevement,'Inconnu');\r\n";
                fwrite($ecritSQL,$sql);
                $req++;
                //echo $sql,"<br/>";
                
            }
            fclose($litSangliersPrlvt);
            fclose($ecritSQL);

            /////////////////////////////////////////////////////////////////////
            ///// Fichier de données: Temperature+vent.csv
            ///// --> TABLE Lieu
            ///// --> TABLE Donnees_externes
            ///// --> TABLE Date_donnees_externes
            ///// --> TABLE relever_meteo
            /////////////////////////////////////////////////////////////////////


            $ecritSQL = fopen($SQL08 , "w");

            echo "<br/><br/>";


            $litThermo = fopen($source08,"r");
            $entete = fgetcsv($litThermo, 0, $sep);


            $sql="INSERT INTO Lieu(id_lieu,nom_lieu) VALUES(1,'Évreux');\r\n";
                fwrite($ecritSQL,$sql);


            $cpt=0;
            $req=0;
            while (($data = fgetcsv($litThermo, 0, $sep)) !== FALSE) {
                $cpt++;
                $Temp=$data[1];
                $Annee_mois=$data[2];
                $Vent=$data[3];

                $sql="INSERT INTO Donnees_externes(vent,temp) VALUES('$Vent','$Temp');\r\n";
                fwrite($ecritSQL,$sql);
                $req++;

                $sql="INSERT INTO Date_donnees_externes(id_meteo,annee_mois) VALUES('$cpt','$Annee_mois');\r\n";
                fwrite($ecritSQL,$sql);
                $req++;

                $sql="INSERT INTO relever_meteo(id_meteo,annee_mois,id_lieu) VALUES('$cpt','$Annee_mois',1);\r\n";
                fwrite($ecritSQL,$sql);
                $req++;
            }
            echo("<h3>\r\nCréation de l'ensemble des requêtes SQL terminée</h3>")
        ?>
    </body>
</html>