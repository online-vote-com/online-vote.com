<style>
    /* ==========================================================================
   FOOTER PREMIUM UX/UI COMPONENT (STYLE MINIMALISTE MAT)
   ========================================================================== */
.footer {
    width: 100%;
    background: #F8F9FA; /* Fond neutre mat très doux */
    margin-top: 80px;
    border-top: 1px solid rgba(0, 0, 0, 0.04);
    padding-top: 60px;
}

.footer-main {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px 40px;
}

/* GRILLE DU PIED DE PAGE */
.footer-grid {
    display: grid;
    grid-template-columns: 1.4fr 0.9fr 1fr 1.2fr;
    gap: 48px;
    padding-bottom: 48px;
}

/* BRANDING HARMONISÉ (LOGO + TEXTE) */
.footer-logo {
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    margin-bottom: 20px;
}

.footer-logo-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
}

.footer-logo-img {
    height: 34px; /* Proportion parfaite pour le pied de page */
    width: auto;
    object-fit: contain;
    display: block;
}

.footer-brand-name {
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--text-dark);
    letter-spacing: -0.02em;
}

.footer-description {
    font-size: 0.9rem;
    line-height: 1.6;
    color: var(--text-muted);
    max-width: 300px;
}

/* STRUCTURE DES COLONNES */
.footer-column {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.footer-column h4 {
    font-size: 0.9rem;
    font-weight: 800;
    color: var(--text-dark);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 8px;
}

.footer-link,
.footer-info-text {
    text-decoration: none;
    color: var(--text-muted);
    font-size: 0.9rem;
    font-weight: 500;
    transition: color 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.footer-link:hover {
    color: var(--main-purple); /* Rappel subtil de l'accent violet de la marque */
}

/* CONFIGURATION DU FORMULAIRE DE NEWSLETTER (SANS ARC DE CERCLE) */
.footer-news-text {
    font-size: 0.88rem;
    color: var(--text-muted);
    line-height: 1.5;
    margin-bottom: 6px;
}

.newsletter-form {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
}

.newsletter-form input {
    width: 100%;
    height: 48px;
    background: var(--white);
    border: 1px solid var(--gray-border);
    border-radius: 12px; /* Exit l'arrondi lourd à 16px */
    padding: 0 16px;
    font-size: 0.9rem;
    color: var(--text-dark);
    outline: none;
    transition: border-color 0.2s ease;
}

.newsletter-form input:focus {
    border-color: var(--main-purple);
}

.btn-newsletter-submit {
    width: 100%;
    height: 48px;
    border: none;
    border-radius: 12px; /* Alignement rigoureux du rayon géométrique */
    background: var(--text-dark); /* Puissance et pureté du bouton noir */
    color: var(--white);
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.25s cubic-bezier(0.16, 1, 0.3, 1), transform 0.1s ease;
}

.btn-newsletter-submit:hover {
    background: var(--main-purple);
}

.btn-newsletter-submit:active {
    transform: scale(0.98); /* Retour haptique visuel haut de gamme */
}

/* ==========================================================================
   ZONE DES RECONNAISSANCES LÉGALES ET COPYRIGHT
   ========================================================================== */
.footer-bottom {
    width: 100%;
    padding-top: 24px;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.copyright-text {
    font-size: 0.82rem;
    color: var(--text-muted);
    font-weight: 500;
}

.footer-bottom-links {
    display: flex;
    align-items: center;
    gap: 24px;
}

.footer-bottom-links a {
    text-decoration: none;
    color: var(--text-muted);
    font-size: 0.82rem;
    font-weight: 500;
    transition: color 0.2s ease;
}

.footer-bottom-links a:hover {
    color: var(--main-purple);
}

/* ==========================================================================
   RESPONSIVE DESIGN (BREAKPOINT SÉCURISÉ TABLETTES & MOBILE)
   ========================================================================== */
@media(max-width: 900px) {
    .footer {
        padding-top: 40px;
    }

    .footer-grid {
        grid-template-columns: 1fr; /* Bascule en colonne unique et fluide */
        gap: 36px;
        padding-bottom: 36px;
    }

    .footer-description {
        max-width: 100%;
    }

    .footer-bottom {
        flex-direction: column-reverse; /* Met le copyright sous les liens légaux sur smartphone */
        align-items: center;
        text-align: center;
        gap: 16px;
    }
    
    .footer-bottom-links {
        justify-content: center;
        flex-wrap: wrap;
        gap: 16px 20px;
    }
}

</style>

<footer class="footer">

    <!-- MAIN FOOTER ZONE -->
    <div class="footer-main">
        <div class="footer-grid">

            <!-- BRAND COLUMN (Harmonisé avec la Navbar) -->
            <div class="footer-brand">
                <a href="index.php" class="footer-logo">
                    <div class="footer-logo-wrapper">
                        <img src="assets/images/logo.png" alt="Online Vote" class="footer-logo-img">
                        <span class="footer-brand-name">Online Vote</span>
                    </div>
                </a>
                <p class="footer-description">
                    Simplifiez l’organisation de vos votes, élections et concours grâce à une plateforme pensée pour la transparence, la sécurité et l’engagement.
                </p>
            </div>

            <!-- COLUMN 1 : NAVIGATION -->
            <div class="footer-column">
                <h4>Navigation</h4>
                <a href="index.php" class="footer-link">Accueil</a>
                <a href="concours.php" class="footer-link">Concours</a>
                <a href="#" class="footer-link">À propos</a>
                <a href="#" class="footer-link">Contact</a>
            </div>

            <!-- COLUMN 2 : CONTACT INFOS -->
            <div class="footer-column">
                <h4>Contact & Support</h4>
                <span class="footer-info-text"><i class="fas fa-map-marker-alt"></i> Yaoundé, Cameroun</span>
                <span class="footer-info-text"><i class="fas fa-phone-alt"></i> +237 650 082 325</span>
                <span class="footer-info-text"><i class="fas fa-envelope"></i> contact@online-vote.com</span>
            </div>

            <!-- COLUMN 3 : NEWSLETTER (Correction des balises coupées) -->
            <div class="footer-column">
                <h4>Rester informé</h4>
                <p class="footer-news-text">Inscrivez-vous pour suivre l'actualité des scrutins et l'ouverture des prochains concours.</p>
                
                <form action="#" method="POST" class="newsletter-form">
                    <input type="email" name="email_newsletter" placeholder="Votre adresse email" required aria-label="Adresse email">
                    <button type="submit" class="btn-newsletter-submit">S'abonner</button>
                </form>
            </div>

        </div>

        <!-- BOTTOM LEGAL ZONE -->
        <div class="footer-bottom">
            <p class="copyright-text">&copy; <?= date('Y') ?> Online Vote. Tous droits réservés.</p>
            <div class="footer-bottom-links">
                <a href="#">Mentions légales</a>
                <a href="#">Politique de confidentialité</a>
                <a href="#">CGU</a>
            </div>
        </div>
    </div>

</footer>
