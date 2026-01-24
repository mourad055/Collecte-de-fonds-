<?php
/**
 * Configuration de la connexion à la base de données
 * Classe Database pour gérer la connexion PDO
 */

class Database {
    // Paramètres de connexion
    private $host = "localhost";
    private $db_name = "gestion_financiere";  // Nom de votre base de données
    private $username = "root";                // Votre utilisateur MySQL
    private $password = "";                    // Votre mot de passe MySQL
    private $charset = "utf8mb4";
    
    public $conn;

    /**
     * Établir la connexion à la base de données
     * @return PDO|null Retourne l'objet de connexion ou null en cas d'erreur
     */
    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch(PDOException $exception) {
            echo "Erreur de connexion à la base de données : " . $exception->getMessage();
            error_log("Erreur DB: " . $exception->getMessage());
        }

        return $this->conn;
    }

    /**
     * Fermer la connexion
     */
    public function closeConnection() {
        $this->conn = null;
    }
}
?>
```

---

### Étape 2 : Commiter le fichier

En bas de la page :

1. **Message du commit** :
```
   feat: ajout configuration connexion base de données
```

2. **Description** (optionnel) :
```
   - Classe Database avec méthode getConnection()
   - Gestion des erreurs PDO
   - Configuration MySQL avec charset UTF-8
```

3. **Vérifiez** :
```
   ✓ Commit directly to the feature/suivi-transactions branch
