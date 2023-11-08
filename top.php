<?php
session_start();
$phpSelf = htmlspecialchars($_SERVER['PHP_SELF']);
$path_parts = pathinfo($phpSelf);
?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset="UTF-8">
        <title>RNTR - Honest Apartment Reviews for Burlington, VT</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Noel Desmarais">
        <meta name="description" content="RNTR is a platform that allows renters in Burlington, Vermont to get honest information about landlords and apartment reviews from real people">
        <link rel="stylesheet" href="css/custom.css?version=<?php print time(); ?>" type="text/css">
        <link rel="stylesheet" media="(max-width: 800px)" href="css/custom-tablet.css?version=<?php print time(); ?>" type="text/css">
        <link rel="stylesheet" media="(max-width: 600px)" href="css/custom-phone.css?version=<?php print time(); ?>" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,700|Montserrat:300">
    </head>
<?php
    print '<body id="' . $path_parts['filename'] . '">'
?>
<?php
include 'nav.php';
include 'connect-DB.php';
print PHP_EOL;
?>