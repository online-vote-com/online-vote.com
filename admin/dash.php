    <?php 
        include 'requetteDash.php';
    ?>
 

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Online Vote|Tableau de Bord</title>
        
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link rel="stylesheet" href="../assets/css/newsidebar.css">
        <link rel="stylesheet" href="../assets/css/concours.css">
        <link rel="stylesheet" href="../assets/css/formulaire_nouveau.css">
    </head>
    <body>

    <div class="dashboard-layout">


    
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-square"><i class="fas fa-check-double"></i></div>
                    <span class="logo-text">Online Vote</span>
                  
                </div>
                
                <button class="toggle-btn" id="toggleSidebar"><i class="fas fa-bars-staggered"></i></button>
                
            </div>

            <nav class="sidebar-nav">
                <div class="nav-group">
                    <span class="group-title">Général</span>
                    <a href="#" class="menu-item active" data-section="dashboard">
                        <i class="fa-solid fa-house"></i> <span>Vue d'ensemble</span>
                    </a>
                </div>

                <div class="nav-group">
                    
                    <span class="group-title">Gestion</span>
                    <a href="#" class="menu-item" data-section="concours" title="Concours"><i class="fa-solid fa-trophy"></i> <span>Concours</span></a>
                    <!--<a href="#" class="menu-item" data-section="candidats" title="Candidats"><i class="fa-solid fa-users"></i> <span>Candidats</span></a>-->
                    <a href="#" class="menu-item" data-section="votants" title="Votants"><i class="fa-solid fa-id-card"></i> <span>Votants</span></a>
                    <?php if($_SESSION['role'] == 'admin'){ ?>
                    <a href="#" class="menu-item" data-section="oragnisateurs" title="Oragnisateurs"><i class="fa-solid fa-id-card"></i> <span>Oragnisateurs</span></a>
                    <?php } ?>
                </div>

                <div class="nav-group">
                    <span class="group-title">Finance</span>
                    <a href="#" class="menu-item" data-section="transactions" title="Transactions"><i class="fa-solid fa-receipt"></i> <span>Transactions</span></a>
                    <a href="#" class="menu-item" data-section="retraits" title="Retraits"><i class="fa-solid fa-building-columns"></i> <span>Retraits</span></a>
                </div>

                <div class="nav-group">
                    <span class="group-title">Système</span>
                    <a href="#" class="menu-item" data-section="paramètres" title="Parametres"> <i class="fa-solid fa-sliders"></i> <span>Paramètres</span></a>
                    
                </div>
            </nav>

           <!-- <div class="sidebar-footer">
                    <div class="user-info">
                        <img src="https://ui-avatars.com/api/?name=Arthur+Junior&background=9C04DA&color=fff" alt="Avatar">
                        <div class="details">
                            <p class="name">Arthur Junior</p>
                            <p class="role">Organisateur</p>
                        </div>
                    </div>
                </div>
            -->
        </aside>

        <main class="main-content">

            <header class="top-bar">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Rechercher un concours, un candidat...">
                    <div class="alert">
                        <?php
                            if (isset($_SESSION['message'])){
                                echo "<h4>". $_SESSION['message']. "</h4>";
                                unset($_SESSION['message']);
                            }
                            ?>
                    </div>
                    </div>
                                <!-- Affichage des alertes -->

                    <div class="top-actions">
                        <button class="icon-btn"><i class="fa-regular fa-bell"></i><span class="dot"></span></button>
                       <!-- <button class="btn-primary"><i class="fa-solid fa-plus"></i> Nouveau Concours</button>-->
                        <div class="sidebar-footer">
                            <div class="user-info">
                                <img src="<?php echo $_SESSION['photo']; ?>" alt="Avatar">
                                <div class="details">
                                    <p class="name"><?php echo $_SESSION['nom']; ?></p>
                                    <p class="role"><?php echo $_SESSION['role']; ?></p>
                                </div>
                         </div>
                     </div>
                </div>
            </header>

            <section id="dashboard" class="content-section active">



                <div id="overview" class="view-section">
                    <div class="view-header">
                        <div>
                            <h1>Tableau de bord</h1>
                            <p>Résumé de vos activités de vote au 15 avril 2026</p>
                        </div>
                    </div>

                    <div class="kpi-grid">
                        <div class="kpi-card">
                            <div class="kpi-header">
                                <span class="label">Total Concours</span>
                                <div class="icon purple"><i class="fa-solid fa-flag"></i></div>
                            </div>
                            <div class="kpi-body">
                                <h2><?php echo  $nbrConcours; ?></h2>
                                <span class="trend up"><i class="fa-solid fa-arrow-up"></i> +2</span>
                            </div>
                        </div>
                        <div class="kpi-card">
                            <div class="kpi-header">
                                <span class="label">Votes Totaux</span>
                                <div class="icon blue"><i class="fa-solid fa-check-to-slot"></i></div>
                            </div>
                            <div class="kpi-body">
                                <h2><?php echo $totalVotes; ?></h2>
                                <span class="trend up"><i class="fa-solid fa-arrow-up"></i> +12%</span>
                            </div>
                        </div>
                        <div class="kpi-card">
                            <div class="kpi-header">
                                <span class="label">Revenus (FCFA)</span>
                                <div class="icon yellow"><i class="fa-solid fa-wallet"></i></div>
                            </div>
                            <div class="kpi-body">
                                <h2><?php echo $stats['revenus_nets']; ?></h2>
                                <span class="trend up"><i class="fa-solid fa-arrow-up"></i> +8%</span>
                            </div>
                        </div>

                        <div class="kpi-card">
                            <div class="kpi-header">
                                <span class="label">Votants actifs</span>
                                <div class="icon purple"><i class="fa-solid fa-user-tie"></i></div>
                            </div>
                            <div class="kpi-body">
                                <h2><?php echo $stats['votants_actifs']; ?></h2>
                                <span class="trend up"><i class="fa-solid fa-arrow-up"></i> +8%</span>
                            </div>
                        </div>
                        
                        <div class="kpi-card">
                            <div class="kpi-header">
                                <span class="label">Vote d'aujourd'hui</span>
                                <div class="icon purple"><i class="fa-solid fa-check-to-slot"></i></div>
                            </div>
                            <div class="kpi-body">
                                <h2><?php echo $stats['votes_aujourdhui']; ?></h2>
                                <span class="trend up"><i class="fa-solid fa-arrow-up"></i> +8%</span>
                            </div>
                        </div>

                        <div class="kpi-card">
                            <div class="kpi-header">
                                <span class="label">Candidats</span>
                                <div class="icon green"><i class="fa-solid fa-user-tie"></i></div>
                            </div>
                            <div class="kpi-body">
                                <h2><?php echo $nbrC; ?></h2>
                                <span class="trend neutral">0%</span>
                            </div>
                        </div>
                    </div>

                    <div class="analytics-grid">
                        <div class="chart-container main-chart">
                            <div class="chart-header">
                                <h3>Évolution des votes</h3>
                                <select class="select-soft">
                                    <option>7 derniers jours</option>
                                    <option>30 derniers jours</option>
                                </select>
                            </div>
                            <canvas id="votesChart"></canvas>
                        </div>

                        <div class="chart-container side-card">
                            <h3>Objectif Concours Star</h3>
                            <p class="sub">Miss Cameroun 2026</p>
                            <div class="progress-box">
                                <div class="progress-labels">
                                    <span>Progression des votes</span>
                                    <span>78%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 78%;"></div>
                                </div>
                                <p class="goal-text">Objectif : 10,000 votes</p>
                            </div>
                            <hr class="divider">
                            <h4>Top Concours</h4>
                            <ul class="top-list">
                                <?php   foreach($topConcours  as $tcon){ ?>
                                <li>
                                    <span class="rank"><?php echo $tcon['rang']; ?></span>
                                    <span class="name"><?php echo $tcon['titre']; ?></span>
                                    <span class="val">Votes : <?php echo $tcon['total_votes']; ?></span>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>

                    <div class="table-container">
                        <div class="table-header">
                            <h3>Concours récents</h3>
                            <button class="btn-ghost">Voir tout</button>
                        </div>
                        <div class="table-responsive"> <table>
                                <thead>
                                    <tr>
                                        <th>Concours</th>
                                        <th>Status</th>
                                        <th>Votes</th>
                                        <th>Date Fin</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="contest-cell">
                                                <div class="img-placeholder">
                                                    <i class="fa-solid fa-image"></i>
                                                </div>
                                                <span class="contest-name">Génie d'Afrique 2026</span>
                                            </div>
                                        </td>
                                        <td><span class="status-badge active">En cours</span></td>
                                        <td class="fw-600">3,402</td>
                                        <td>20 Mai 2026</td>
                                        <td class="actions">
                                            <button class="action-btn view" title="Statistiques">
                                                <i class="fa-solid fa-chart-line"></i>
                                            </button>
                                            <button class="action-btn edit" title="Modifier">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button class="action-btn delete" title="Supprimer">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section id="concours" class="content-section">  <?php  include 'concours/concours.php'; ?> </section>
            <section id="candidats" class="content-section"> <?php  include 'candidats.php'; ?> </section>
            <section id="votants" class="content-section"> <?php  include 'votants.php'; ?> </section>
            <section id="oragnisateur" class="content-section"> <?php  include 'oragnisateur.php'; ?> </section>
            <section id="transactions" class="content-section"> <?php  include 'transactions.php'; ?> </section>
            <section id="retraits" class="content-section"> <?php  include 'retraits.php'; ?> </section>
            <section id="paramètres" class="content-section"> <?php  include 'parametres.php'; ?> </section>
        </main>
    </div>

    <script src="script.js"></script>
    </body>
    </html>

    <script >const ctx = document.getElementById('votesChart');

    new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'],
        datasets: [{
        data: [120, 190, 300, 250, 220, 400, 500],
        borderColor: '#7C3AED',
        backgroundColor: 'rgba(124, 58, 237, 0.08)',
        fill: true,
        tension: 0.4,
        pointRadius: 0
        }]
    },
    options: {
        plugins: {
        legend: { display: false }
        },
        scales: {
        x: { grid: { display: false } },
        y: {
            grid: { color: "#F1F5F9" },
            ticks: { color: "#94A3B8" }
        }
        }
    }
    });

    //transition entre les sections 
  
document.querySelectorAll('.menu-item').forEach(button => {

    button.addEventListener('click', (e) => {

        e.preventDefault();

        const idPointe = button.getAttribute('data-section');

        // Active menu
        document.querySelectorAll('.menu-item').forEach(btn =>
            btn.classList.remove('active')
        );
        button.classList.add('active');

        // Cache toutes les sections
        document.querySelectorAll('.content-section').forEach(section => {
            section.classList.remove('active');
        });

        // Affiche la bonne section
        const target = document.getElementById(idPointe);

        if (target) {
            target.classList.add('active');
        } else {
            console.error("Section introuvable :", idPointe);
        }

    });

});

/*Ouverture fermeture du sidebar */

    const sideBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    sideBtn.addEventListener('click', () =>{
        sidebar.classList.toggle('collapsed');
    });


</script>

   

