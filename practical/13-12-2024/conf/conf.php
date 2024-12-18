
<?php
define('HOST', '127.0.0.1:3306');
define('USERNAME', 'root');
define('PWD', 'mariadb');
define('DB', 'ICAE02');

try {
    $connection = mysqli_connect(HOST,USERNAME,PWD,DB);
    if(!$connection){
        die("Database not connected!");
    }
    else{
        echo "Database connected succefully!";
    }
} catch (Exception $e) {
    die($e->getMessage());
}
echo "<br>";
?>
