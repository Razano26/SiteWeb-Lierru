<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>new</title>
    </head>
    <body>
        <?php
            $dsn = 'mysql:host=localhost;dbname=PS3_V2;port=3306;charset=utf8mb4';
            $pdo = new PDO($dsn, 'root' , 'stidps3'); 

            if(isset($_POST["Requette"]))
                $requette=$_POST["Requette"];
        ?>
        

        <form method="POST">
            <input type="text" name="Requette"></input>
            <input type="submit" value="Executer"></input>
        </form>
    
        <?php

            if(isset($requette)){
                $query = $pdo->query("'".$requette.";'");
                $resultat = $query->fetchAll();
                echo($query);
            }

        ?>


    </body>
</html>