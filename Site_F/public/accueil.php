<main class="container detail-container">
    <div class="detail-wrapper">
        
        <div class="detail-image-box">
            <img src="../assets/images/organisateur/art.jpg" alt="Affiche" class="img-fluid-rounded">
        </div>

        <div class="detail-content-box">
            
            <div class="detail-info-box">
                <div class="info-meta">
                    <p><strong>Rang :</strong> 01 | <strong>Candidat :</strong> #001</p>
                    <h2 class="candidate-full-name">Chakoualeu Arthur</h2>
                    <p class="contest-name"><strong>Concours :</strong> NOM CONCOURS</p>
                </div>

                <div class="description-section">
                    <h3>Ma Description</h3>
                    <p class="description-text">
                        La Méthode du Marché ("Approche par comparaison") est une technique d'évaluation 
                        financière et technique basée sur les prix du marché actuel.
                    </p>
                </div>
            </div>

            <hr class="separator">

            <div class="vote-form-box">
                <div class="vote-header-info">
                    <span class="nb-info">NB : 1 Vote = Montant Unitaire</span>
                    <span class="rank-info">Votes : 345</span>
                </div>

                <form class="vote-inputs-grid">
                    <div class="form-row">
                        <div class="select-wrapper">
                            <select name="paiement" required>
                                <option value="" disabled selected>Mode paiement</option>
                                <option value="om">Orange Money</option>
                                <option value="momo">MTN Mobile Money</option>
                            </select>
                        </div>
                        <div class="static-field purple-field">Montant</div>
                    </div>

                    <div class="full-width-field purple-gradient-field">
                        <input type="tel" placeholder="Entrer votre numéro de téléphone" class="transparent-input">
                    </div>

                    <div class="form-row align-center">
                        <div class="total-box">
                            Vote total = <span class="vote-count">1000</span>
                        </div>
                        <button type="submit" class="btn-vote-submit">Voter</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</main>