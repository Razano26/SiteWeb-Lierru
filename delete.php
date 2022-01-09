<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/stylepage.css">
    <title>new</title>
    </head>
    
    <body>
    <?php
        $dsn = 'mysql:host=localhost;dbname=PS3_V2;port=3306;charset=utf8mb4';
        $pdo = new mysqli($dsn, 'root' , 'stidps3');
        //Check connection
        if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        mysqli_query($pdo,"DELETE FROM Arbre WHERE id='$id'");
        mysqli_close($pdo);
        header("Location: index.php");
?> 
    </body>
</html>