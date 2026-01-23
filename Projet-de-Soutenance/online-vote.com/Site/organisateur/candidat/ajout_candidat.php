
<div id="modalCandidat" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            Candidat
        </div>
        <div class="modal-body">
            <p class="instruction-text">Tous les champs marqués avec * sont obligatoires</p>
            
            <form id="formCandidat" method="post" action="">
                <div class="form-group-row">
                    <div class="form-group">
                        <input type="text" class="form-input" placeholder="Nom *">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-input" placeholder="Prénom *">
                    </div>
                </div>

                <div class="form-group">
                    <input type="email" class="form-input" placeholder="Email *">
                </div>

                <div class="form-group-row">
                    <div class="form-group">
                        <select class="form-input">
                            <option value="">Concours *</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-input" placeholder="Photo">
                    </div>
                </div>

                <div class="form-group">
                    <textarea class="form-input" placeholder="Biographie"></textarea>
                </div>

                <button type="submit" class="btn-confirm">Confirmer</button>
            </form>
        </div>
    </div>
</div>
