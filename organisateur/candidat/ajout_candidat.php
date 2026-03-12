<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/formulaire_nouveau.css">
<div id="modalCandidat" class="modal">
    <div class="modal-content">

        <div class="modal-header">
            <h2>Nouveau Candidat</h2>
            <p>Tous les champs marqués avec * sont obligatoires</p>
        </div>

        <form class="modal-body" method="post" action="">

            <div class="form-row">
                <input type="text" placeholder="Nom *" required>
                <input type="text" placeholder="Prénom *" required>
            </div>

            <input type="email" placeholder="Email *" class="full-width" required>

            <div class="form-row">
                <div class="select-wrapper">
                    <select required>
                        <option value="" disabled selected>Concours *</option>
                        <?php foreach($concours as $concours_item){ ?>
                            <option value="<?= $concours_item['id_concours'] ?>"><?= $concours_item['titre'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="file-input">
                    <input type="file" id="photo" accept="image/png,image/jpeg" hidden>
                    <label for="photo">Photo</label>
                </div>
            </div>

            <textarea placeholder="Biographie" class="full-width"></textarea>

            <div class="form-footer">
                <button type="submit" class="btn-submit">Ajouter</button>
            </div>

        </form>
    </div>
</div>

