<?php 
    include 'includes/link.php';
    
    include 'accueil.php';
    ?>
    
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Vote | Votez en toute confiance</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="main-header">
    <div class="header-container">
        <div class="logo">
            <span class="online">O</span><span class="line-text">NLINE</span>
            <span class="vote-tag">vote</span>
        </div>

        <nav class="nav-menu">
            <ul> 
                <li><a href="index">Acceuil</a></li>
                <li><a href="#">A propos</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="concours">concours</a></li>
            </ul>
        </nav>

        <?php if(isset($_SESSION['id_user'])) { ?>
            <div class="header-actions">
                <a href="profil_user" class="btn-connect">Mon Profil</a>
         <?php } else { ?>
                <a href="login" class="btn-connect">Se connecter</a>
         <?php } ?>
        </div>
    </div>
</header>



    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <i class="fas fa-check-circle"></i> <span>Online Vote</span>
            </div>
            <div class="nav-links">
                <a href="#comment-ca-marche">Comment ça marche ?</a>
                <a href="#securite">Sécurité</a>
                <a href="login.php" class="btn-login">Connexion</a>
                <a href="signup.php" class="btn-cta-nav">Démarrer</a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="badge">Sûr • Transparent • Incorruptible</div>
                <h1>Le vote digital, aussi simple qu'un <span>SMS</span>.</h1>
                <p>Organisez vos scrutins institutionnels ou vos concours payants sur la plateforme la plus fiable du marché. Une expérience fluide pour les votants, un contrôle total pour vous.</p>
                <div class="cta-group">
                    <button class="btn-primary">Créer mon premier vote</button>
                    <button class="btn-secondary"><i class="fas fa-play"></i> Voir la démo</button>
                </div>
            </div>
            <div class="hero-app-preview">
                <div class="phone-mockup">
                    <div class="phone-screen">
                        <div class="app-header">Vote en cours</div>
                        <div class="poll-card">
                            <p>Élection de la coopérative 2026</p>
                            <div class="option"><span>Candidat A</span> <i class="far fa-circle"></i></div>
                            <div class="option active"><span>Candidat B</span> <i class="fas fa-check-circle"></i></div>
                            <button class="btn-vote">Valider mon vote</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="comment-ca-marche">
        <div class="container">
            <div class="section-header">
                <h2>Conçu pour tous les besoins</h2>
                <p>Une flexibilité totale pour vos projets de consultation.</p>
            </div>
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="f-icon purple"><i class="fas fa-coins"></i></div>
                    <h3>Concours Payants</h3>
                    <p>Idéal pour les événements TV, Miss, ou Talents. Intégration Mobile Money native.</p>
                </div>
                <div class="feature-card">
                    <div class="f-icon blue"><i class="fas fa-landmark"></i></div>
                    <h3>Scrutins Officiels</h3>
                    <p>Élections de délégués, bureaux de coopératives ou assemblées générales.</p>
                </div>
                <div class="feature-card">
                    <div class="f-icon green"><i class="fas fa-user-shield"></i></div>
                    <h3>Anonymat Garanti</h3>
                    <p>Chiffrement de bout en bout. L'identité du votant est protégée par notre protocole.</p>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
<style>
  :root {
    --primary: #9C04DA;
    --primary-dark: #6D0399;
    --text-dark: #0F172A;
    --text-muted: #64748B;
    --bg-light: #F8FAFC;
    --white: #FFFFFF;
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text-dark);
    background: var(--white);
    line-height: 1.6;
}

.container { max-width: 1140px; margin: 0 auto; padding: 0 24px; }

/* NAVBAR */
.navbar {
    height: 80px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #F1F5F9;
}

.navbar .container { display: flex; justify-content: space-between; align-items: center; width: 100%; }

.logo { font-weight: 800; font-size: 1.4rem; color: var(--primary); display: flex; align-items: center; gap: 10px; }

.nav-links { display: flex; align-items: center; gap: 30px; }
.nav-links a { text-decoration: none; color: var(--text-muted); font-weight: 600; font-size: 0.9rem; transition: 0.3s; }
.nav-links a:hover { color: var(--primary); }

.btn-cta-nav {
    background: var(--primary); color: white !important;
    padding: 10px 20px; border-radius: 10px;
}

/* HERO */
.hero { padding: 80px 0; background: linear-gradient(180deg, #FDFCFE 0%, #FFFFFF 100%); }
.hero .container { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 60px; align-items: center; }

.badge {
    background: #F5E6FF; color: var(--primary);
    padding: 6px 14px; border-radius: 100px; font-size: 0.75rem; font-weight: 700;
    margin-bottom: 24px; display: inline-block;
}

.hero h1 { font-size: 3.8rem; line-height: 1.1; margin-bottom: 24px; font-weight: 800; }
.hero h1 span { color: var(--primary); }
.hero p { font-size: 1.1rem; color: var(--text-muted); margin-bottom: 40px; max-width: 550px; }

.cta-group { display: flex; gap: 15px; }
.btn-primary {
    background: var(--primary); color: white; border: none;
    padding: 16px 32px; border-radius: 12px; font-weight: 700; font-size: 1rem;
    cursor: pointer; box-shadow: 0 10px 20px rgba(156, 4, 218, 0.2);
}

.btn-secondary {
    background: #F1F5F9; color: var(--text-dark); border: none;
    padding: 16px 32px; border-radius: 12px; font-weight: 700; font-size: 1rem; cursor: pointer;
}

/* PHONE MOCKUP (Le côté Application) */
.phone-mockup {
    background: #111; border-radius: 40px; padding: 12px;
    width: 300px; height: 580px; margin: 0 auto;
    box-shadow: 0 50px 100px rgba(0,0,0,0.1); border: 4px solid #F1F5F9;
}

.phone-screen {
    background: var(--bg-light); border-radius: 30px;
    height: 100%; width: 100%; overflow: hidden; padding: 20px;
}

.app-header { font-weight: 800; text-align: center; margin-bottom: 30px; }
.poll-card { background: white; padding: 20px; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
.poll-card p { font-size: 0.9rem; font-weight: 700; margin-bottom: 20px; }

.option {
    border: 1px solid #E2E8F0; padding: 12px; border-radius: 12px;
    margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;
    font-size: 0.8rem; font-weight: 600;
}
.option.active { border-color: var(--primary); color: var(--primary); background: #FAF5FF; }

.btn-vote {
    width: 100%; background: var(--primary); color: white; border: none;
    padding: 12px; border-radius: 12px; margin-top: 15px; font-weight: 700;
}

/* FEATURES */
.features { padding: 100px 0; }
.section-header { text-align: center; margin-bottom: 60px; }
.section-header h2 { font-size: 2.2rem; font-weight: 800; }

.feature-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
.feature-card {
    padding: 40px; border-radius: 24px; border: 1px solid #F1F5F9;
    transition: 0.3s;
}
.feature-card:hover { transform: translateY(-10px); border-color: var(--primary); }

.f-icon { width: 50px; height: 50px; border-radius: 12px; display: grid; place-items: center; margin-bottom: 20px; font-size: 1.2rem; }
.purple { background: #F5E6FF; color: var(--primary); }
.blue { background: #E0F2FE; color: #0369A1; }
.green { background: #DCFCE7; color: #15803D; }

@media (max-width: 768px) {
    .hero .container { grid-template-columns: 1fr; text-align: center; }
    .hero h1 { font-size: 2.5rem; }
    .hero-app-preview { display: none; }
    .feature-grid { grid-template-columns: 1fr; }
    .cta-group { justify-content: center; }
}
</style>
    <?php
   
  //  include 'public/concours.php' ;
    // include 'public/concours_detail.php' ;
     include 'includes/footer.php' ;
?>




