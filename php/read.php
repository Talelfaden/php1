<?php
include 'functions.php';
// Connexion à la base de données MySQL
$pdo = pdo_connect_mysql();
/* Récupère la page via la requête GET (param URL : page),
 si elle n'existe pas, la page est définie par défaut sur 1*/
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Nombre d'enregistrements à afficher sur chaque page
$records_per_page = 5;
// Préparez l'instruction SQL et obtenez les enregistrements de notre table de contacts, LIMIT déterminera la page
/*
Cette ligne de code prépare une requête SQL pour sélectionner toutes les données de la table "contacts",
 triées par ordre croissant de l'identifiant (ID), avec une limitation du nombre de résultats retournés. 
La limitation est déterminée par deux paramètres qui sont ":current_page" : détermine la page de résultats actuelle à afficher,
 en commençant par 0 pour la première page.":record_per_page" : détermine le nombre maximum de résultats à retourner par page.
 */
$stmt = $pdo->prepare('SELECT * FROM contacts ORDER BY id LIMIT :current_page, :record_per_page');

/* :current_page et :record_per_page: Ce sont des marqueurs
 de paramètres nommés dans la requête préparée. Ils permettent de 
 créer une requête SQL paramétrée, ce qui aide à éviter les attaques par 
 injection SQL et permet également de réutiliser la même requête 
 avec différentes valeurs de paramètres. */

//effectuer une pagination dans une liste de résultats en récupérant les enregistrements correspondant à la page demandée
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Récupérez les enregistrements afin que nous puissions les afficher dans notre modèle.
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Obtenez le nombre total de contacts, afin que nous puissions déterminer s'il devrait y avoir un bouton suivant et précédent
$num_contacts = $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
    <h2>Read Contacts</h2>
    <a href="create.php" class="create-contact">Create Contact</a>
    <table>
        <thead>
            <tr>
                <td>#</td>
                <td>Name</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Title</td>
                <td>Created</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?=$contact['id']?></td>
                <td><?=$contact['name']?></td>
                <td><?=$contact['email']?></td>
                <td><?=$contact['phone']?></td>
                <td><?=$contact['title']?></td>
                <td><?=$contact['created']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$contact['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$contact['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php if ($page > 1): ?>
        <a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
        <?php endif; ?>
        <?php if ($page*$records_per_page < $num_contacts): ?>
        <a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
        <?php endif; ?>
    </div>
</div>

<?=template_footer()?>