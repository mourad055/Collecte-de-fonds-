<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier client</title>
    <style>
        :root {
            --main-green: #0E8D4D;
            --green-dark: #0b6f3d;
            --white: #fff;
            --input-bg: #f6f7fa;
            --border-radius: 18px;
            --shadow-form: 0 7px 32px rgba(14, 141, 77, 0.11), 0 1.5px 10px rgba(14,141,77,0.09), 0 1px 15px rgba(33,34,60,0.08);
            --transition: 0.21s cubic-bezier(.8,.4,.2,1);
        }

        body {
            min-height: 100vh;
            background: var(--white);
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .card-form {
            background: var(--white);
            padding: 44px 32px 32px 32px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-form);
            min-width: 350px;
            width: 100%;
            max-width: 410px;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .card-form h2 {
            margin: 0 0 16px 0;
            color: var(--main-green);
            font-weight: 800;
            font-size: 2rem;
            text-align: center;
            letter-spacing: 0.3px;
            background: linear-gradient(90deg, var(--main-green), var(--green-dark) 90%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .input-group label {
            font-size: 1.07rem;
            color: #232323;
            font-weight: 600;
        }

        .custom-input {
            background: var(--input-bg);
            border: 1.5px solid #d2f3e3;
            outline: none;
            font-size: 1.07rem;
            color: #222;
            border-radius: 10px;
            padding: 13px 14px;
            transition: border-color var(--transition), box-shadow var(--transition);
            box-shadow: 0 1.5px 6px rgba(14,141,77,0.07);
        }

        .custom-input:focus {
            border-color: var(--main-green);
            box-shadow: 0 0 0 2px #c1eddb;
        }

        .custom-btn {
            background: linear-gradient(100deg, var(--main-green) 90%, var(--green-dark));
            color: var(--white);
            border: none;
            border-radius: 8px;
            padding: 15px 0;
            font-weight: 700;
            font-size: 1.14rem;
            cursor: pointer;
            margin-top: 10px;
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
            box-shadow: 0 2px 14px rgba(14,141,77,0.13);
        }

        .custom-btn:hover, .custom-btn:focus {
            background: linear-gradient(100deg, var(--green-dark) 80%, var(--main-green));
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 7px 18px rgba(14,141,77,0.13);
        }

        .back-btn {
            background: linear-gradient(90deg, #fff 80%, var(--main-green) 100%);
            color: var(--main-green);
            border: 2px solid var(--main-green);
            border-radius: 8px;
            padding: 12px 0;
            font-weight: 600;
            font-size: 1.04rem;
            cursor: pointer;
            width: 100%;
            margin-top: 8px;
            text-align: center;
            text-decoration: none;
            transition: background var(--transition), color var(--transition), border-color var(--transition), box-shadow var(--transition);
            display: block;
            box-shadow: 0 1px 7px rgba(14,141,77,0.06);
        }

        .back-btn:hover, .back-btn:focus {
            background: linear-gradient(90deg, var(--main-green) 90%, #fff 130%);
            color: #fff;
            border-color: var(--green-dark);
            box-shadow: 0 4px 14px rgba(14,141,77,0.13);
        }

        @media (max-width: 700px) {
            .card-form { min-width: unset; padding: 20px 8px; max-width: 99vw; gap: 16px; }
            .card-form h2 { font-size: 1.17rem; }
            .custom-btn, .custom-input, .back-btn { font-size: 0.97rem; }
        }
    </style>
</head>
<body>
    <form method="POST" action="{{ route('clients.update', $client->id_cli) }}" class="card-form">
        <h2>Modifier les informations du client</h2>
        @csrf
        @method('PUT')

        <div class="input-group">
            <label for="nom_cli">Nom</label>
            <input id="nom_cli" type="text" name="nom_cli" class="custom-input" value="{{ old('nom_cli', $client->nom_cli) }}" placeholder="Entrez le nom" required>
        </div>
        <div class="input-group">
            <label for="prenom_cli">Prénom</label>
            <input id="prenom_cli" type="text" name="prenom_cli" class="custom-input" value="{{ old('prenom_cli', $client->prenom_cli) }}" placeholder="Entrez le prénom" required>
        </div>
        <div class="input-group">
            <label for="tel_cli">Téléphone</label>
            <input id="tel_cli" type="text" name="tel_cli" class="custom-input" value="{{ old('tel_cli', $client->tel_cli) }}" placeholder="Entrez le numéro de téléphone" required>
        </div>
        <div class="input-group">
            <label for="adresse_cli">Adresse</label>
            <input id="adresse_cli" type="text" name="adresse_cli" class="custom-input" value="{{ old('adresse_cli', $client->adresse_cli) }}" placeholder="Entrez l'adresse" required>
        </div>
        <div class="input-group">
            <label for="solde_cli">Solde</label>
            <input id="solde_cli" type="text" name="solde_cli" class="custom-input" value="{{ old('solde_cli', $client->solde_cli) }}" placeholder="Entrez le solde" required>
        </div>
        <button type="submit" class="custom-btn">Enregistrer</button>
        <a href="{{ route('clients.index') }}" class="back-btn">Retour à la liste</a>
    </form>
</body>
</html>
