<?php

define('BASE_URL', '/Projet-de-Soutenance/Site/'); 

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamer-vote</title>
    <!-- Google Fonts -->
     <link rel="stylesheet" href="<?= BASE_URL ?>https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <!-- CSS -->

    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/color.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/tableau.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/grid-card.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/navbar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/inscription.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/accueil.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/footer.css">
</head>
<body>
<?php 
include './includes/navbar.php';
include './public/accueil.php';
include './includes/footer.php';
?>