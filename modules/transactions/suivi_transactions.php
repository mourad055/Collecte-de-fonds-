<?php
/**
 * Page principale de suivi des transactions
 * Affiche les transactions avec filtres et statistiques
 */

require_once '../../config/database.php';
require_once 'Transaction.php';

// Démarrer la session si nécessaire
session_start();

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Vérifier la connexion
if ($db === null) {
    die("Erreur : Impossible de se connecter à la base de données.");
}

// Initialiser l'objet Transaction
$transaction = new Transaction($db);

// Récupérer les critères de recherche depuis l'URL
$criteres = [
    'date_debut' => $_GET['date_debut'] ?? null,
    'date_fin' => $_GET['date_fin'] ?? null,
    'type' => $_GET['type'] ?? null,
    'statut' => $_GET['statut'] ?? null,
    'montant_min' => $_GET['montant_min'] ?? null,
    'montant_max' => $_GET['montant_max'] ?? null
];

// Récupérer les transactions selon les critères
if (array_filter($criteres)) {
    $stmt = $transaction->rechercherTransactions($criteres);
} else {
    $stmt = $transaction->lireTransactions();
}

// Récupérer les statistiques
$stats = $transaction->obtenirStatistiques($criteres['date_debut'], $criteres['date_fin']);

// Protection contre les valeurs nulles dans les stats
$stats['total_transactions'] = $stats['total_transactions'] ?? 0;
$stats['total_encaissements'] = $stats['total_encaissements'] ?? 0;
$stats['total_decaissements'] = $stats['total_decaissements'] ?? 0;
$stats['solde'] = $stats['solde'] ?? 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des Transactions - Gestion Financière</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        header {
            margin-bottom: 30px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
        }

        h1 {
            color: #333;
            font-size: 32px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .subtitle {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Statistiques */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card.green {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .stat-card.red {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .stat-card.blue {
            background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
        }

        .stat-card h3 {
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 10px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-card .value {
            font-size: 32px;
            font-weight: bold;
            margin-top: 5px;
        }

        /* Filtres */
        .filters {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
        }

        .filters h2 {
            color: #333;
            font-size: 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filters form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            font-size: 13px;
            color: #555;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .filters input,
        .filters select {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            width: 100%;
            transition: border-color 0.3s ease;
        }

        .filters input:focus,
        .filters select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            grid-column: 1 / -1;
        }

        .filters button {
            padding: 12px 30px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filters button:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-reset {
            background: #6c757d !important;
        }

        .btn-reset:hover {
            background: #5a6268 !important;
        }

        /* Tableau */
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        thead {
            background: #667eea;
            color: white;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }

        tbody tr {
            transition: background-color 0.2s ease;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge.encaissement {
            background: #d4edda;
            color: #155724;
        }

        .badge.decaissement {
            background: #f8d7da;
            color: #721c24;
        }

        .badge.valide {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge.en-attente {
            background: #fff3cd;
            color: #856404;
        }

        .badge.annule {
            background: #e2e3e5;
            color: #383d41;
        }

        /* Message quand aucune transaction */
        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .no-data .icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .no-data h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #666;
        }

        .no-data p {
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            h1 {
                font-size: 24px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .filters form {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📊 Suivi des Transactions</h1>
            <p class="subtitle">Gestion et analyse des transactions financières</p>
        </header>

        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-card blue">
                <h3>Total Transactions</h3>
                <div class="value"><?php echo number_format($stats['total_transactions']); ?></div>
            </div>
            <div class="stat-card green">
                <h3>Total Encaissements</h3>
                <div class="value"><?php echo number_format($stats['total_encaissements'], 0, ',', ' '); ?> FCFA</div>
            </div>
            <div class="stat-card red">
                <h3>Total Décaissements</h3>
                <div class="value"><?php echo number_format($stats['total_decaissements'], 0, ',', ' '); ?> FCFA</div>
            </div>
            <div class="stat-card">
                <h3>Solde</h3>
                <div class="value"><?php echo number_format($stats['solde'], 0, ',', ' '); ?> FCFA</div>
            </div>
        </div>

        <!-- Filtres de recherche -->
        <div class="filters">
            <h2>🔍 Filtrer les transactions</h2>
            <form method="GET" action="">
                <div class="filter-group">
                    <label>Date début</label>
                    <input type="date" name="date_debut" value="<?php echo htmlspecialchars($_GET['date_debut'] ?? ''); ?>">
                </div>

                <div class="filter-group">
                    <label>Date fin</label>
                    <input type="date" name="date_fin" value="<?php echo htmlspecialchars($_GET['date_fin'] ?? ''); ?>">
                </div>

                <div class="filter-group">
                    <label>Type</label>
                    <select name="type">
                        <option value="">Tous les types</option>
                        <option value="encaissement" <?php echo ($_GET['type'] ?? '') == 'encaissement' ? 'selected' : ''; ?>>Encaissement</option>
                        <option value="decaissement" <?php echo ($_GET['type'] ?? '') == 'decaissement' ? 'selected' : ''; ?>>Décaissement</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Statut</label>
                    <select name="statut">
                        <option value="">Tous les statuts</option>
                        <option value="valide" <?php echo ($_GET['statut'] ?? '') == 'valide' ? 'selected' : ''; ?>>Validé</option>
                        <option value="en-attente" <?php echo ($_GET['statut'] ?? '') == 'en-attente' ? 'selected' : ''; ?>>En attente</option>
                        <option value="annule" <?php echo ($_GET['statut'] ?? '') == 'annule' ? 'selected' : ''; ?>>Annulé</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Montant minimum</label>
                    <input type="number" name="montant_min" placeholder="0" value="<?php echo htmlspecialchars($_GET['montant_min'] ?? ''); ?>">
                </div>

                <div class="filter-group">
                    <label>Montant maximum</label>
                    <input type="number" name="montant_max" placeholder="1000000" value="<?php echo htmlspecialchars($_GET['montant_max'] ?? ''); ?>">
                </div>

                <div class="filter-buttons">
                    <button type="submit">🔍 Rechercher</button>
                    <button type="button" class="btn-reset" onclick="window.location.href='suivi_transactions.php'">🔄 Réinitialiser</button>
                </div>
            </form>
        </div>

        <!-- Tableau des transactions -->
        <div class="table-container">
            <?php if ($stmt->rowCount() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Description</th>
                        <th>Méthode</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($row['reference']); ?></strong></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($row['date_transaction'])); ?></td>
                        <td>
                            <span class="badge <?php echo $row['type']; ?>">
                                <?php echo $row['type'] == 'encaissement' ? '💰 ' : '💸 '; ?>
                                <?php echo ucfirst($row['type']); ?>
                            </span>
                        </td>
                        <td style="font-weight: bold; font-size: 15px; color: <?php echo $row['type'] == 'encaissement' ? '#28a745' : '#dc3545'; ?>">
                            <?php echo number_format($row['montant'], 0, ',', ' '); ?> FCFA
                        </td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo htmlspecialchars($row['methode_paiement']); ?></td>
                        <td>
                            <span class="badge <?php echo $row['statut']; ?>">
                                <?php echo ucfirst(str_replace('-', ' ', $row['statut'])); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="no-data">
                <div class="icon">📭</div>
                <h3>Aucune transaction trouvée</h3>
                <p>Essayez de modifier vos critères de recherche ou ajoutez de nouvelles transactions.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
```

---

### Étape 2 : Commiter le fichier

En bas de la page :

1. **Message du commit** :
```
   feat: ajout interface suivi transactions avec filtres et stats
```

2. **Description** :
```
   - Interface complète avec tableau de bord
   - Filtres de recherche avancés (dates, type, statut, montants)
   - Statistiques en temps réel
   - Design responsive et moderne
```

3. **Vérifiez** :
```
   ✓ Commit directly to the feature/suivi-transactions branch
