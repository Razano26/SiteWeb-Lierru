<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
    <body>
            <?php
                $dsn = 'mysql:host=localhost;dbname=PS3_V2;port=3306;charset=utf8mb4';

                $pdo = new PDO($dsn, 'root' , 'stidps3');

                $lire = file_get_contents("MCD-Lierru_MySQL-V2.txt");
                $query = $pdo->query($lire)


            ?>
    </body>
</html>