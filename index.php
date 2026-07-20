<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
 <?php include 'includes/link.php'; ?>
    <?php include 'includes/header.php'; ?>
    
</head>

<body>
    <?php include "chatbot/chatbot.php"; ?>

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/hero.php'; ?>


    <?php /* include 'includes/hero1.php'; 
    include 'includes/marche.php'; 
   include 'includes/contact.php'; */?>
 
    <?php // include 'includes/footer.php'; ?>

    
<script src="assets/js/chatbot.js"></script>
<script src="assets/js/landing.js"></script>
</body>
</html>