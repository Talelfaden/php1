<?php
//Fonction du configuration et du connexion à une base de données MySQL
function pdo_connect_mysql() {
    // Configuration des informations de la base de données
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'phpcrud7';
    //saisie d'une exception potentielle
    try {
         // Connexion à la base de données mysql avec PDO
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
        // S'il y a une erreur avec la connexion, arrêtez le script et affichez l'erreur.
        exit('Failed to connect to database!');
    }
}

/*Le fonction template_header($title)  est communément utilisé dans les sites web pour inclure le code HTML et les éléments visuels 
qui sont répétés sur toutes les pages du site, tels que la barre de navigation, le logo du site,
 les liens vers les réseaux sociaux, etc.*/ 

function template_header($title) {
    /* EOT est un délimiteur de chaîne de caractères en PHP.
     Il est utilisé pour définir une chaîne de caractères multilignes appelée heredoc.*/
echo <<<EOT
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>$title</title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    </head>
    <body>
    <nav class="navtop">
        <div>
            <h1>Website Title</h1>
            <a href="index.php"><i class="fas fa-home"></i>Home</a>
            <a href="read.php"><i class="fas fa-address-book"></i>Contacts</a>
        </div>
    </nav>
EOT;
}

/*La fonction template_footer() est communément utilisé dans les sites web pour inclure les éléments communs au pied de page
 de chaque page du site, tels que les liens de navigation secondaire,
 les coordonnées de contact, etc.*/
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>