<?php include "style.php"; ?>

<?php include "header.php"; ?>

<div class="hero">
    <h1><?= $concours['titre'] ?></h1>
    <p>
        Organisateur : <?= $concours['nom_user'] ?> <br>
        Statut : <?= $concours['status_concours'] ?>
    </p>
</div>

<div class="grid">

    <div class="card">
        <h2><?= $stats['total_votes'] ?></h2>
        <p>Votes</p>
    </div>

    <div class="card">
        <h2><?= $stats['total_votants'] ?></h2>
        <p>Votants</p>
    </div>

    <div class="card">
        <h2><?= $stats['total_candidats'] ?></h2>
        <p>Candidats</p>
    </div>

    <div class="card">
        <h2><?= number_format($stats['revenus'],0,' ',' ') ?> FCFA</h2>
        <p>Revenus</p>
    </div>

</div>

<h3>Classement des candidats</h3>

<table>
    <tr>
        <th>#</th>
        <th>Nom</th>
        <th>Votes</th>
    </tr>

<?php $i = 1; foreach ($candidats as $c): ?>

    <tr>
        <td><?= $i++ ?></td>
        <td><?= $c['nom_candidat'] ?> <?= $c['prenom_candidat'] ?></td>
        <td><?= $c['total_votes'] ?></td>
    </tr>

<?php endforeach; ?>

</table>

<?php include "footer.php"; ?>