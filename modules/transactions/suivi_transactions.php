<?php
require_once '../../config/database.php';
require_once 'Transaction.php';

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Initialiser l'objet Transaction
$transaction = new Transaction($db);

// Récupérer les critères de recherche
$criteres = [
    'date_debut' => $_GET['date_debut'] ?? null,
    'date_fin' => $_GET['date_fin'] ?? null,
    'type' => $_GET['type'] ?? null,
    'statut' => $_GET['statut'] ?? null,
    'montant_min' => $_GET['montant_min'] ?? null,
    'montant_max' => $_GET['montant_max'] ?? null
];

// Récupérer les transactions
if (array_filter($criteres)) {
    $stmt = $transaction->rechercherTransactions($criteres);
} else {
    $stmt = $transaction->lireTransactions();
}

// Récupérer les statistiques
$stats = $transaction->obtenirStatistiques($criteres['date_debut'], $criteres['date_fin']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des Transactions</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 30px; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; }
        .stat-card.green { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
        .stat-card.red { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
        .stat-card.blue { background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); }
        .stat-card h3 { font-size: 14px; margin-bottom: 10px; opacity: 0.9; }
        .stat-card .value { font-size: 28px; font-weight: bold; }
        
        .filters { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
        .filters form { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .filters input, .filters select { padding: 10px; border: 1px solid #ddd; border-radius: 4px; width: 100%; }
        .filters button { padding: 10px 20px; background: #667eea; color: white; border: none; border-radius: 4px; cursor: pointer; grid-column: span 2; }
        .filters button:hover { background: #5568d3; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #667eea; color: white; font-weight: 600; }
        tr:hover { background: #f8f9fa; }
        
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge.encaissement { background: #d4edda; color: #155724; }
        .badge.decaissement { background: #f8d7da; color: #721c24; }
        .badge.valide { background: #d1ecf1; color: #0c5460; }
        .badge.en-attente { background: #fff3cd; color: #856404; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 Suivi des Transactions</h1>
        
        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-card blue">
                <h3>Total Transactions</h3>
                <div class="value"><?php echo number_format($stats['total_transactions']); ?></div>
            </div>
            <div class="stat-card green">
                <h3>Total Encaissements</h3>
                <div class="value"><?php echo number_format($stats['total_encaissements'], 2); ?> FCFA</div>
            </div>
            <div class="stat-card red">
                <h3>Total Décaissements</h3>
                <div class="value"><?php echo number_format($stats['total_decaissements'], 2); ?> FCFA</div>
            </div>
            <div class="stat-card">
                <h3>Solde</h3>
                <div class="value"><?php echo number_format($stats['solde'], 2); ?> FCFA</div>
            </div>
        </div>
        
        <!-- Filtres -->
        <div class="filters">
            <form method="GET" action="">
                <input type="date" name="date_debut" placeholder="Date début" value="<?php echo $_GET['date_debut'] ?? ''; ?>">
                <input type="date" name="date_fin" placeholder="Date fin" value="<?php echo $_GET['date_fin'] ?? ''; ?>">
                
                <select name="type">
                    <option value="">Tous les types</option>
                    <option value="encaissement" <?php echo ($_GET['type'] ?? '') == 'encaissement' ? 'selected' : ''; ?>>Encaissement</option>
                    <option value="decaissement" <?php echo ($_GET['type'] ?? '') == 'decaissement' ? 'selected' : ''; ?>>Décaissement</option>
                </select>
                
                <select name="statut">
                    <option value="">Tous les statuts</option>
                    <option value="valide" <?php echo ($_GET['statut'] ?? '') == 'valide' ? 'selected' : ''; ?>>Validé</option>
                    <option value="en-attente" <?php echo ($_GET['statut'] ?? '') == 'en-attente' ? 'selected' : ''; ?>>En attente</option>
                </select>
                
                <input type="number" name="montant_min" placeholder="Montant min" value="<?php echo $_GET['montant_min'] ?? ''; ?>">
                <input type="number" name="montant_max" placeholder="Montant max" value="<?php echo $_GET['montant_max'] ?? ''; ?>">
                
                <button type="submit">🔍 Rechercher</button>
            </form>
        </div>
        
        <!-- Tableau des transactions -->
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
                    <td><?php echo htmlspecialchars($row['reference']); ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($row['date_transaction'])); ?></td>
                    <td><span class="badge <?php echo $row['type']; ?>"><?php echo ucfirst($row['type']); ?></span></td>
                    <td style="font-weight: bold; color: <?php echo $row['type'] == 'encaissement' ? '#28a745' : '#dc3545'; ?>">
                        <?php echo number_format($row['montant'], 2); ?> FCFA
                    </td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['methode_paiement']); ?></td>
                    <td><span class="badge <?php echo $row['statut']; ?>"><?php echo ucfirst($row['statut']); ?></span></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
