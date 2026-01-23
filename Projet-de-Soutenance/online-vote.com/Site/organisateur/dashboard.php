<?php

define('BASE_URL', '/Projet-de-Soutenance/Site/'); 

?>
    <!-- CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/color.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/tableau.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/accueil.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/footer.css">

    <div class="container">
        <aside class="sidebar">
            <div class="profile-section">
                <img src="../assets/images/organisateur/art.jpg" alt="Avatar" class="avatar-large">
                <h3>Arthur CHAKOUALEU</h3>
            </div>
            <nav class="menu">
                <p class="menu-label">Général</p>
                <ul>
                    <li class="active">Stats rapides</li>
                    <li>Gérer un concours</li>
                    <li>Gérer les candidats</li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="top-bar">
                <div class="top-nav-links">Messages | Notifications</div>
                <div class="profile-badge">
                    <img src="../assets/images/organisateur/art.jpg" alt="Avatar" class="avatar-small">
                    <span>Profil</span>
                </div>
            </header>

            <section class="dashboard-header">
                <h1>Tableau de bord Organisateur</h1>
            </section>

            <section class="stats-container">
                <h2>Stats rapides</h2>
                <div class="stats-grid">
                    <div class="card white-card info-box">
                        <span class="stat-number purple-text ">35</span>
                        <span class="stat-label">Candidats</span>
                    </div>
                    <div class="card black-card info-box">
                        <span class="stat-number yellow-text">35</span>
                        <span class="stat-label">Concours</span>
                    </div>
                    <div class="card white-card info-box">
                        <span class="stat-number purple-text">12500</span>
                        <span class="stat-label">FCFA reçu</span>
                    </div>
                    <div class="card black-card info-box">
                        <span class="stat-number yellow-text">10000</span>
                        <span class="stat-label">Votes</span>
                    </div>
                </div>
            </section>


            <!-- table conours -->
            <section class="tableau-section">
                <h2>Liste de mes concours</h2>
                                <div class="content-card">
                    <div class="filters-container">
                        <span class="filter-label">Filtre</span>
                        <select class="filter-select">
                            <option>Noms</option>
                        </select>
                        <select class="filter-select">
                            <option>Concours</option>
                        </select>
                    </div>   
                <div class="table-container">
                 
                    <table>
                        <thead>
                            <tr>
                                 <th>Noms</th>
                                <th>Descriptions</th>
                                <th>Photos</th>
                                <th>Types</th>
                                <th>Prix (FCFA)</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="dot"></span>Arthur Chakoualeu</td>
                                <td>Concours de miss et Masters</td>
                                <td><img src="../assets/images/organisateur/art.jpg" class="table-img avatar-small"></td>
                                <td>gratuit</td>
                                <td>500</td>
                                <td>attente</td>
                                <td>
                                    <button class="btn-delete">Supprimer</button>
                                    <button class="btn-edit">Modifier</button>
                                    <button class="btn-add">Ajouter</button>
                                    <button class="btn-stats">Statistiques</button>
                                 </td>
                            </tr>
                            </tbody>
                    </table>
                    <div class="table-actions">
                        

                    </div>
                </div>
                </div>
            </section>


            <!--table candidats -->

            <div class="tableau-section">
                <h2>Liste des candidats</h2>

                <div class="content-card">
                    <div class="filters-container">
                        <span class="filter-label">Filtre</span>
                        <select class="filter-select">
                            <option>Noms</option>
                        </select>
                        <select class="filter-select">
                            <option>Concours</option>
                        </select>
                    </div>

                    <table class="table-container">
                        <thead>
                            <tr>
                                <th>Noms</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Photos</th>
                                <th>Bios</th>
                                <th>Concours</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Chakoualeu</td>
                                <td>Arthur</td>
                                <td>email@gameil.com</td>
                                <td><img src="../assets/images/organisateur/art.jpg" class="table-img avatar-small"></td>
                                <td>Passionné</td>
                                <td>Master</td>
                                <td class="actions-cell">
                                    <button class="btn-delete">Supprimer</button>
                                    <button class="btn-add">Ajouter</button>
                                    <button class="btn-edit">Modifier</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </main>
    </div>


    

<?php 
 include 'candidat/ajout_candidat.php'; 
    include '../includes/footer.php'; 
   
?>