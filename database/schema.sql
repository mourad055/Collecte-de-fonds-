-- Table pour gérer les transactions financières
CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('encaissement', 'decaissement') NOT NULL COMMENT 'Type de transaction',
    montant DECIMAL(15, 2) NOT NULL COMMENT 'Montant de la transaction',
    description TEXT COMMENT 'Description détaillée',
    date_transaction DATETIME NOT NULL COMMENT 'Date et heure de la transaction',
    statut ENUM('valide', 'en-attente', 'annule') DEFAULT 'valide' COMMENT 'Statut de la transaction',
    methode_paiement VARCHAR(50) COMMENT 'Méthode de paiement (espèces, carte, virement, etc.)',
    reference VARCHAR(100) UNIQUE COMMENT 'Référence unique de la transaction',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date de modification',
    
    INDEX idx_date (date_transaction),
    INDEX idx_type (type),
    INDEX idx_statut (statut),
    INDEX idx_reference (reference)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Quelques données de test (optionnel - à supprimer en production)
INSERT INTO transactions (type, montant, description, date_transaction, statut, methode_paiement, reference) VALUES
('encaissement', 50000.00, 'Vente produit A', NOW(), 'valide', 'espèces', 'TRX-2025-001'),
('encaissement', 75000.00, 'Vente produit B', NOW(), 'valide', 'carte', 'TRX-2025-002'),
('decaissement', 25000.00, 'Achat fournitures', NOW(), 'valide', 'virement', 'TRX-2025-003'),
('encaissement', 100000.00, 'Prestation service', NOW(), 'en-attente', 'virement', 'TRX-2025-004'),
('decaissement', 15000.00, 'Frais transport', NOW(), 'valide', 'espèces', 'TRX-2025-005');
```

---

### Étape 2 : Commiter le fichier

En bas de la page, dans "Commit new file" :

1. **Message du commit** :
```
   feat: ajout schéma SQL table transactions
```

2. **Description** (optionnel) :
```
   - Structure complète de la table transactions
   - Index pour optimiser les recherches
   - Données de test incluses
```

3. **Vérifiez que c'est coché** :
```
   ✓ Commit directly to the feature/suivi-transactions branch
