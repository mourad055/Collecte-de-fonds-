<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des clients</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --vert: #0E8D4D;
            --vert-fonce: #0b6f3d;
            --blanc: #fff;
            --gris-clair: #f8f9fa;
            --gris: #e0e0e0;
            --ombre: 0 6px 30px 3px rgba(14, 141, 77, 0.11);
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            background: var(--gris-clair);
            min-height: 100vh;
        }

        header {
            background: linear-gradient(90deg, var(--vert), #19ce80 90%);
            padding: 45px 0 22px 0;
            box-shadow: var(--ombre);
            text-align: center;
            border-bottom-left-radius: 28px;
            border-bottom-right-radius: 28px;
            margin-bottom: 26px;
        }

        h2 {
            margin: 0;
            color: var(--blanc);
            font-size: 2.7em;
            letter-spacing: 2px;
            font-weight: 900;
            text-shadow: 2px 4px 14px rgba(14, 141, 77, 0.12);
        }

        .container {
            max-width: 1100px;
            margin: 0 auto 35px auto;
            background: var(--blanc);
            border-radius: 24px;
            box-shadow: var(--ombre);
            padding: 40px 38px 35px 38px;
            position: relative;
        }

        .success-message {
            color: var(--vert);
            background: #e9ffe9;
            border-radius: 10px;
            padding: 16px 24px;
            margin-bottom: 28px;
            font-size: 1.08em;
            box-shadow: 0 1px 5px 0 rgba(14, 141, 77, 0.06);
            text-align: center;
            border-left: 6px solid var(--vert);
            font-weight: 600;
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 14px;
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            min-width: 700px;
            background: var(--blanc);
            margin-top: 10px;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: var(--ombre);
        }

        th {
            background: linear-gradient(90deg, var(--vert), #19ce80 80%);
            color: var(--blanc);
            padding: 20px 10px;
            font-size: 1.13em;
            font-weight: 700;
            letter-spacing: 1px;
            border: none;
            text-align: center;
        }

        td {
            padding: 16px 9px;
            text-align: center;
            border-bottom: 1.5px solid var(--gris);
            background: var(--blanc);
            font-size: 1.04em;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .btn, button.btn {
            background: linear-gradient(90deg, var(--vert), #19ce80 80%);
            color: var(--blanc);
            border: none;
            padding: 10px 19px;
            margin: 4px 2px;
            border-radius: 22px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
            transition: background 0.18s, transform 0.13s, box-shadow 0.12s;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 2px 10px 0 rgba(14, 141, 77, 0.08);
            outline: none;
        }

        .btn:hover, button.btn:hover, .btn:focus-visible, button.btn:focus-visible {
            background: linear-gradient(90deg, var(--vert-fonce), #19ce80 65%);
            transform: translateY(-2px) scale(1.06);
            box-shadow: 0 4px 20px 0 rgba(14, 141, 77, 0.12);
        }

        a.btn.add {
            margin-top: 36px;
            font-size: 1.19em;
            padding: 15px 48px;
            font-weight: bold;
            border: 3px solid #19ce80;
        }

        @media (max-width: 1020px) {
            .container { padding: 18px 8px 16px 8px; }
            th, td { padding: 11px 6px; font-size: 0.96em; }
            h2 { font-size: 2em; }
        }

        @media (max-width: 700px) {
            .container { padding: 4vw 0.5vw 2vw 0.5vw; }
            th, td { padding: 7px 2px; font-size: 0.92em; }
            h2 { font-size: 1.15em; }
            table {
                min-width: 400px;
            }
        }

        /* Extra professional touch: Floating plus button on mobile */
        @media (max-width: 600px) {
            a.btn.add {
                position: fixed;
                right: 18px;
                bottom: 18px;
                border-radius: 100%;
                padding: 17px 0;
                width: 62px;
                height: 62px;
                font-size: 2em;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 20px 0 rgba(14, 141, 77, 0.14);
                z-index: 9999;
                margin-top: 0;
            }
            .add-text {
                display: none;
            }
            .add-icon {
                display: inline;
            }
        }
        @media (min-width: 601px) {
            .add-icon { display: none }
        }
    </style>
</head>
<body>

<header>
    <h2>Liste des clients enregistrés</h2>
</header>

<div class="container">
    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    <div class="table-wrapper">
    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Téléphone</th>
            <th>Adresse</th>
            <th>Solde</th>
            <th>Actions</th>
        </tr>

        @forelse($clients as $client)
            <tr>
                <td>{{ $client->nom_cli }}</td>
                <td>{{ $client->prenom_cli }}</td>
                <td>{{ $client->tel_cli }}</td>
                <td>{{ $client->adresse_cli }}</td>
                <td>{{ $client->solde_cli }}</td>
                <td>
                    <a href="{{ route('clients.edit', $client->id_cli) }}" class="btn" title="Modifier">
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" style="vertical-align: middle; margin-bottom: -3px;"><path d="M15.232 5.232a2 2 0 012.828 2.828l-.586.586-2.828-2.828.586-.586zm-1.414 1.414L4 16.464V20h3.536l9.818-9.818-2.828-2.828z" fill="white"/></svg>
                    </a>
                    <form action="{{ route('clients.destroy', $client->id_cli) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" onclick="return confirm('Supprimer ce client ?')" title="Supprimer">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" style="vertical-align: middle; margin-bottom: -3px;"><path d="M6 19a2 2 0 002 2h8a2 2 0 002-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" fill="white"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="color:#888;font-style:italic;">Aucun client trouvé dans la base.</td>
            </tr>
        @endforelse
    </table>
    </div>

    <a href="{{ route('clients.create') }}" class="btn add"
        title="Ajouter un client">
        <span class="add-text">+ Ajouter un client</span>
        <span class="add-icon">+</span>
    </a>
</div>

<!-- 
ROUTE À AJOUTER DANS routes/web.php :
Route::resource('clients', \App\Http\Controllers\ClientController::class);
-->
</body>
</html> 
