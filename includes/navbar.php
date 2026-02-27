

<link rel="stylesheet" href="assets/css/navbar.css">

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
