<!-- Liens CSS -->
<link rel="stylesheet" href="../assets/css/profile_candidat.css">
<link rel="stylesheet" href="../assets/css/color.css">

<main class="container detail-container">
    <div class="detail-wrapper">

        <!-- Image du candidat -->
        <div class="detail-image-box">
            <img src="../assets/images/organisateur/art.jpg" alt="Affiche" class="img-fluid-rounded">
        </div>

        <!-- Contenu principal -->
        <div class="detail-content-box">

            <!-- Informations du candidat -->
            <div class="detail-info-box">
                <div class="info-meta">
                    <p>
                        <strong>Rang :</strong> 01 | 
                        <strong>Candidat :</strong> #001
                    </p>
                    <h2 class="candidate-full-name">Chakoualeu Arthur</h2>
                    <p class="contest-name"><strong>Concours :</strong> NOM CONCOURS</p>
                </div>

                <!-- Description du candidat -->
                <div class="description-section">
                    <h3>Ma Description</h3>
                    <p class="description-text">
                        La Méthode du Marché ("Approche par comparaison") est une technique d'évaluation 
                        financière et technique. Elle consiste à déterminer la valeur d'un logiciel...
                    </p>
                </div>
            </div>

            <hr class="separator">

            <!-- Section vote -->
            <div class="vote-form-box">

                <div class="vote-header-info">
                    <span class="nb-info">NB : Montant Vote (unitaire) = 1 Vote</span>
                    <span class="rank-info">Votes actuels : 345</span>
                </div>

               <form class="vote-inputs-grid">
    <!-- Sélection du mode de paiement -->
    <div class="form-row">
        <div class="select-wrapper">
            <select name="paiement" required>
                <option value="" disabled selected>Mode paiement</option>
                <option value="om">Orange Money</option>
                <option value="momo">MTN Mobile Money</option>
            </select>
        </div>

        <!-- Montant (champ texte) -->
        <div class="full-width-field purple-gradient-field">
            <input type="number" name="montant" placeholder="Entrer le montant" class="transparent-input" required>
        </div>
    </div>

    <!-- Numéro de téléphone (champ texte) -->
    <div class="full-width-field purple-gradient-field">
        <input type="tel" name="telephone" placeholder="Entrer votre numéro de téléphone" class="transparent-input" required>
    </div>

    <!-- Total votes + bouton -->
    <div class="form-row align-center">
        <div class="total-box">
            Vote total = <span class="vote-count">1000</span>
        </div>
        <button type="submit" class="btn-vote-submit">Voter</button>
    </div>
</form>


            </div> <!-- Fin section vote -->

        </div> <!-- Fin contenu principal -->

    </div> <!-- Fin wrapper -->
</main>
