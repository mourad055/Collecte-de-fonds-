<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire client</title>
    <style>
        :root {
            --main-green: #0E8D4D;
            --green-dark: #0b6f3d;
            --white: #fff;
            --input-bg: #f7f7f7;
            --border-radius: 16px;
            --shadow: 0 6px 32px rgba(14, 141, 77, 0.19), 0 1.5px 10px rgba(0,0,0,0.15);
            --transition: 0.22s cubic-bezier(.8,.4,.2,1.5);
        }

        body {
            min-height: 100vh;
            background: var(--white); /* Blanc pur en fond */
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-form {
            background: var(--white);
            padding: 40px 32px 32px 32px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            min-width: 370px;
            width: 100%;
            max-width: 410px;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .card-form h2 {
            margin: 0 0 18px 0;
            color: var(--main-green);
            font-weight: 700;
            font-size: 2rem;
            text-align: center;
            letter-spacing: 0.2px;
            background: linear-gradient(90deg, var(--main-green), var(--green-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .input-group label {
            font-size: 1.05rem;
            color: #393939;
            margin-bottom: 3px;
            font-weight: 600;
        }

        .custom-input {
            background: var(--input-bg);
            border: 1.5px solid #d6f5e2;
            outline: none;
            font-size: 1.06rem;
            color: #222;
            border-radius: 10px;
            padding: 13px 14px;
            transition: border-color var(--transition), box-shadow var(--transition);
            box-shadow: 0 1px 4px rgba(14,141,77,0.06);
        }

        .custom-input:focus {
            border-color: var(--main-green);
            box-shadow: 0 0 0 2px #c1eddb;
        }

        .custom-btn {
            background: linear-gradient(100deg, var(--main-green) 80%, var(--green-dark));
            color: var(--white);
            border: none;
            border-radius: 8px;
            padding: 13px 0;
            font-weight: 700;
            font-size: 1.18rem;
            cursor: pointer;
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
            box-shadow: 0 2px 14px rgba(14,141,77,0.13);
        }

        .custom-btn:hover, .custom-btn:focus {
            background: linear-gradient(100deg, var(--green-dark) 80%, var(--main-green));
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 8px 24px rgba(14,141,77,0.19);
        }

        @media (max-width: 600px) {
            .card-form {
                min-width: unset;
                padding: 24px 10px;
                max-width: 98vw;
                gap: 19px;
            }
            .card-form h2 { font-size: 1.3rem; }
            .custom-btn, .custom-input { font-size: 1rem; }
        }
    </style>
</head>
<body>
    <form method="POST" action="{{ route('clients.store') }}" class="card-form">
        <h2>Formulaire d'enregistrement</h2>
        @csrf

        <div class="input-group">
            <label for="nom_cli">Nom</label>
            <input id="nom_cli" type="text" name="nom_cli" class="custom-input" placeholder="Entrez le nom" required>
        </div>
        <div class="input-group">
            <label for="prenom_cli">Prénom</label>
            <input id="prenom_cli" type="text" name="prenom_cli" class="custom-input" placeholder="Entrez le prénom" required>
        </div>
        <div class="input-group">
            <label for="tel_cli">Téléphone</label>
            <input id="tel_cli" type="text" name="tel_cli" class="custom-input" placeholder="Entrez le numéro de téléphone" required>
        </div>
        <div class="input-group">
            <label for="adresse_cli">Adresse</label>
            <input id="adresse_cli" type="text" name="adresse_cli" class="custom-input" placeholder="Entrez l'adresse" required>
        </div>
        <div class="input-group">
            <label for="solde_cli">Solde</label>
            <input id="solde_cli" type="text" name="solde_cli" class="custom-input" placeholder="Solde initial" required>
        </div>
        <button type="submit" class="custom-btn">Envoyer</button>
    </form>
</body>
</html>
