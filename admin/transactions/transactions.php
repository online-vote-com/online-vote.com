
<div class="page-layout">

<section id="transactions" class="content-section">

<!-- ================= VIEW HEADER ================= -->
<div class="view-header">
    <div>
        <h1>Gestion des Transactions</h1>
        <p>Suivi des paiements et revenus en temps réel</p>
    </div>
</div>

<!-- ================= KPI ================= -->
<div class="kpi-grid">

    <div class="kpi-card gradient-orange">
        <div class="kpi-header">
            <span class="label white">Transactions</span>
            <div class="kpi-icon-bg">
                <i class="fa-solid fa-credit-card"></i>
            </div>
        </div>
        <div class="kpi-body">
            <h2 class="white"><?= $kpi['total_transactions'] ?? 0; ?></h2>
            <p class="sub-label white-opacity">Total opérations</p>
        </div>
    </div>

    <div class="kpi-card white-card">
        <div class="kpi-header">
            <span class="label">Montant total</span>
            <div class="kpi-icon-bg gray">
                <i class="fa-solid fa-coins"></i>
            </div>
        </div>
        <div class="kpi-body">
            <h2><?= number_format($kpi['total_montant'] ?? 0, 0, ',', ' '); ?> FCFA</h2>
            <p class="sub-label">Revenus générés</p>
        </div>
    </div>

    <div class="kpi-card white-card">
        <div class="kpi-header">
            <span class="label">Succès</span>
            <div class="kpi-icon-bg green-soft">
                <i class="fa-solid fa-check"></i>
            </div>
        </div>
        <div class="kpi-body">
            <h2><?= $kpi['succes'] ?? 0; ?></h2>
            <p class="sub-label">Paiements validés</p>
        </div>
    </div>

    <div class="kpi-card white-card">
        <div class="kpi-header">
            <span class="label">Échoués</span>
            <div class="kpi-icon-bg gray">
                <i class="fa-solid fa-xmark"></i>
            </div>
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

        <div class="table-actions">
            <button class="btn-ghost">Filtrer</button>
            <button class="btn-ghost">Exporter</button>
        </div>
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
                    <th class="text-right">Actions</th>
                </tr>
            </thead>

            <tbody>

            <?php if (!empty($transactions)): ?>
                <?php foreach ($transactions as $t): ?>
                    <tr>
                        <td>#<?= $t['id_paiement']; ?></td>

                        <td><?= htmlspecialchars($t['concours_titre'] ?? 'N/A'); ?></td>

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

                        <td class="actions">
                            <button class="action-btn view">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;padding:20px;">
                        Aucune transaction trouvée
                    </td>
                </tr>
            <?php endif; ?>

            </tbody>
        </table>

    </div>

</div>
            </section>
            <style>
.page-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
}
/* gauche = transactions */
#transactions {
    flex: 2; /* prend plus de place */
    min-width: 0;
}

/* droite = autre bloc */
.right-panel {
    flex: 1;
    background: white;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
    padding: 20px;
}
            </style>

            </div>