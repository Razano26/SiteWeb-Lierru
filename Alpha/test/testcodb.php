<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>testdbconect</title>
</head>
<body>
    <?php

        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);

        if (extension_loaded ('PDO')) {
        echo 'PDO OK'; 
        } else {
        echo 'PDO KO'; 
        }
        
        print("\n\n\n");

        $dsn = 'mysql:host=localhost;dbname=test;port=3306;charset=utf8mb4';

        $pdo = new PDO($dsn, 'root' , 'stidps3');

        $query = $pdo->query("SELECT * FROM `utilisateur`");
        $query = $pdo->query("INSERT INTO `utilisateur` (`ID`, `name`, `password`) VALUES ('4', 'Loic', 'Trou')");

        $resultat = $query->fetchAll();

        print("<table border=\"1\">");

        foreach ($resultat as $key => $variable)
        {
        print("<tr>");
        print("<td>".$resultat[$key]['name']."</td>");
        print("<td>".$resultat[$key]['password']."</td>");
        print("<tr>");
        }

        print("</table>");

    ?>
</body>
</html>