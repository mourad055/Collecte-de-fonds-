<?php
class Transaction {
    private $conn;
    private $table = "transactions";

    public $id;
    public $type;
    public $montant;
    public $description;
    public $date_transaction;
    public $statut;
    public $methode_paiement;
    public $reference;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer toutes les transactions
    public function lireTransactions($limite = 50, $offset = 0) {
        $query = "SELECT * FROM " . $this->table . " 
                  ORDER BY date_transaction DESC 
                  LIMIT :limite OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }

    // Rechercher des transactions par critères
    public function rechercherTransactions($criteres) {
        $query = "SELECT * FROM " . $this->table . " WHERE 1=1";
        
        if (!empty($criteres['date_debut'])) {
            $query .= " AND date_transaction >= :date_debut";
        }
        if (!empty($criteres['date_fin'])) {
            $query .= " AND date_transaction <= :date_fin";
        }
        if (!empty($criteres['type'])) {
            $query .= " AND type = :type";
        }
        if (!empty($criteres['statut'])) {
            $query .= " AND statut = :statut";
        }
        if (!empty($criteres['montant_min'])) {
            $query .= " AND montant >= :montant_min";
        }
        if (!empty($criteres['montant_max'])) {
            $query .= " AND montant <= :montant_max";
        }
        
        $query .= " ORDER BY date_transaction DESC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!empty($criteres['date_debut'])) {
            $stmt->bindParam(':date_debut', $criteres['date_debut']);
        }
        if (!empty($criteres['date_fin'])) {
            $stmt->bindParam(':date_fin', $criteres['date_fin']);
        }
        if (!empty($criteres['type'])) {
            $stmt->bindParam(':type', $criteres['type']);
        }
        if (!empty($criteres['statut'])) {
            $stmt->bindParam(':statut', $criteres['statut']);
        }
        if (!empty($criteres['montant_min'])) {
            $stmt->bindParam(':montant_min', $criteres['montant_min']);
        }
        if (!empty($criteres['montant_max'])) {
            $stmt->bindParam(':montant_max', $criteres['montant_max']);
        }
        
        $stmt->execute();
        return $stmt;
    }

    // Obtenir les statistiques
    public function obtenirStatistiques($date_debut = null, $date_fin = null) {
        $query = "SELECT 
                    COUNT(*) as total_transactions,
                    SUM(CASE WHEN type = 'encaissement' THEN montant ELSE 0 END) as total_encaissements,
                    SUM(CASE WHEN type = 'decaissement' THEN montant ELSE 0 END) as total_decaissements,
                    SUM(CASE WHEN type = 'encaissement' THEN montant ELSE -montant END) as solde
                  FROM " . $this->table . " WHERE 1=1";
        
        if ($date_debut) {
            $query .= " AND date_transaction >= :date_debut";
        }
        if ($date_fin) {
            $query .= " AND date_transaction <= :date_fin";
        }
        
        $stmt = $this->conn->prepare($query);
        
        if ($date_debut) {
            $stmt->bindParam(':date_debut', $date_debut);
        }
        if ($date_fin) {
            $stmt->bindParam(':date_fin', $date_fin);
        }
        
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer une nouvelle transaction
    public function creer() {
        $query = "INSERT INTO " . $this->table . "
                  (type, montant, description, date_transaction, statut, methode_paiement, reference)
                  VALUES
                  (:type, :montant, :description, :date_transaction, :statut, :methode_paiement, :reference)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':montant', $this->montant);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':date_transaction', $this->date_transaction);
        $stmt->bindParam(':statut', $this->statut);
        $stmt->bindParam(':methode_paiement', $this->methode_paiement);
        $stmt->bindParam(':reference', $this->reference);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
