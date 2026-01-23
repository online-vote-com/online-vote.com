<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/formulaire_nouveau.css">

<div id="modalConcours" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Nouveau Concours</h2>
            <p>Tous les champs marqués avec * sont obligatoires</p>
        </div>
        
        <form class="modal-body" action="votre_script_concours.php" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <input type="text" name="titre" placeholder="Titre *" required>
                <div class="file-input">
                    <input type="file" id="photoConcours" name="photo_concours" hidden>
                    <label for="photoConcours">Photo concours</label>
                </div>
            </div>
            
            <div class="form-row">
                <div class="select-wrapper">
                    <select name="type_vote" required>
                        <option value="" disabled selected>Type de vote</option>
                        <option value="gratuit">Gratuit</option>
                        <option value="payant">Payant</option>
                    </select>
                </div>
                <input type="number" name="prix_vote" placeholder="Prix Vote">
            </div>

            <div class="form-row">
                <input type="text" name="date_debut" placeholder="Date début" onfocus="(this.type='date')">
                <input type="text" name="date_fin" placeholder="Date de fin" onfocus="(this.type='date')">
            </div>
            
            <textarea name="description" placeholder="Description" class="full-width"></textarea>
            
            <div class="form-footer">
                <button type="submit" class="btn-submit">Ajouter</button>
            </div>
        </form>
    </div>
</div>
