
<div class="view-header">
    <div>
        <h1>Transactions</h1>
        <p>Suivi des paiements et revenus en temps réel</p>
    </div>
</div>

<!-- ================= KPI ================= -->
<div class="kpi-grid">

    <div class="kpi-card gradient-orange">
        <div class="kpi-header">
            <span class="label white">Total transactions</span>
        </div>
        <div class="kpi-body">
            <h2 class="white"><?= $kpi['total_transactions'] ?? 0; ?></h2>
            <p class="sub-label white-opacity">Toutes opérations</p>
        </div>
    </div>

    <div class="kpi-card white-card">
        <div class="kpi-header">
            <span class="label">Montant total</span>
        </div>
        <div class="kpi-body">
            <h2><?= number_format($kpi['total_montant'] ?? 0, 0, ',', ' '); ?> FCFA</h2>
            <p class="sub-label">Revenus générés</p>
        </div>
    </div>

    <div class="kpi-card white-card">
        <div class="kpi-header">
            <span class="label">Succès</span>
        </div>
        <div class="kpi-body">
            <h2><?= $kpi['succes'] ?? 0; ?></h2>
            <p class="sub-label">Paiements validés</p>
        </div>
    </div>

    <div class="kpi-card white-card">
        <div class="kpi-header">
            <span class="label">Échoués</span>
        </div>
        <div class="kpi-body">
            <h2><?= $kpi['echoue'] ?? 0; ?></h2>
            <p class="sub-label">Transactions échouées</p>
        </div>
    </div>

</div>

<!-- ================= TABLE ================= -->
<div class="table-container">

    <div class="table-header">
        <h3>Liste des transactions</h3>
    </div>

    <div class="table-responsive">

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Concours</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($transactions as $t): ?>
                <tr>

                    <td>#<?= $t['id_paiement']; ?></td>

                    <td><?= htmlspecialchars($t['concours_titre']); ?></td>

                    <td class="fw-600">
                        <?= number_format($t['montant'], 0, ',', ' '); ?> FCFA
                    </td>

                    <td>
                        <span class="status-badge <?= $t['status_paiement']; ?>">
                            <?= ucfirst($t['status_paiement']); ?>
                        </span>
                    </td>

                    <td>
                        <?= date('d/m/Y H:i', strtotime($t['date_paiement'])); ?>
                    </td>

                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>

    </div>
</div>

<style>
    
</style>