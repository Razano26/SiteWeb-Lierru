<!DOCTYPE html>
<html lang="en" class="fond">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
	<title>Accueil</title>
    <link rel="stylesheet" href="style/stylepage.css">
</head>
<header class="box">
    <nav>
        <ul class="menu" >
                <li><a href="index.php?page=Accueil.php">Accueil</a></li>
                <li><a href="index.php?page=Creation_script.php">Création des requêtes SQL</a></li>
                <li><a href="index.php?page=remplissage.php">Remplissage de la base de données</a></li>
                <li class="deroulant"><a href="index.php?page=new.php">Actions</a>
                    <ul class="sous">
                        <li><a href="index.php?page=Consulter.php">Consulter</a></li>
                        <li><a href="index.php?page=Ajouter.php">Ajouter</a></li>
                        <li><a href="index.php?page=Modifier.php">Modifier</a></li>
                        <li><a href="index.php?page=Supprimer.php">Supprimer</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
</header>
    <body>
        <?php
            if (isset($_GET["page"]))
                $page=$_GET["page"];
            else
                $page="Accueil.php";

        ?>

            <iframe src="<?php echo $page;?>" scrolling="yes" width=100% height=900px id="iframe"></iframe>
    </body>
</html>