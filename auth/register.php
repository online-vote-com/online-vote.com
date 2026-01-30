<div class="modal-container">
    <div class="modal-header">
        <h2>Inscription</h2>
    </div>
    <div class="modal-body">
        <p class="form-instruction">Tous les champs marqués avec * sont obligatoires</p>
        
        <form action="#" method="POST" class="form-grid">
            <div class="form-row">
                <input type="text" placeholder="Nom *" name="nom" required>
                <input type="text" placeholder="Prénom *" name="prenom" required>
            </div>

            <input type="email" placeholder="Email *" name="email" required class="full-width">

            <div class="form-row">
                <input type="password" placeholder="Mot de passe *" name="password" required>
                <div class="file-input-wrapper">
                    <span>Photo</span>
                </div>
            </div>

            <input type="password" placeholder="Confirmation de Mot de passe *" name="confirm_password" required class="full-width">

            <div class="form-row-btn">
                <select name="role" class="select-input">
                    <option value="">Role *</option>
                    <option value="organisateur">Organisateur</option>
                    <option value="electeur">Électeur</option>
                </select>
                <button type="submit" class="btn-confirm-action">Confirmer</button>
            </div>
        </form>

        <div class="modal-footer-links">
            <p>Vous avez déjà un compte ? <a href="#">Connexion</a></p>
            <a href="index.php" class="back-home">Acceuil</a>
        </div>
    </div>
</div>