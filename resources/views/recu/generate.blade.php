<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Reçu</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #0E8D4D, #22c55e);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Poppins', sans-serif;
}
.recu {
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(15px);
    padding: 40px;
    border-radius: 20px;
    width: 600px;
    color: #1f2937;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}
h2 {
    text-align: center;
    color: #0E8D4D;
}
.row {
    display: flex;
    justify-content: space-between;
    margin: 15px 0;
}
hr {
    border: none;
    border-top: 1px solid #d1d5db;
    margin: 20px 0;
}
.actions {
    margin-top: 30px;
    display: flex;
    gap: 10px;
}
button {
    flex: 1;
    padding: 12px;
    border-radius: 12px;
    border: none;
    font-weight: bold;
    cursor: pointer;
}
.print {
    background: linear-gradient(135deg, #0E8D4D, #22c55e);
    color: white;
}
.pdf {
    background: white;
    color: #0E8D4D;
    border: 2px solid #0E8D4D;
}
.pdf:hover {
    background: #0E8D4D;
    color: white;
}
</style>
</head>

<body>

<div class="recu">
    <h2>🧾 Reçu de paiement</h2>
    <p><strong>N° Reçu :</strong> {{ $numero_recu }}</p>

    <div class="row"><span>Client</span><span>{{ $nom }}</span></div>
    <div class="row"><span>Référence</span><span>{{ $reference }}</span></div>
    <div class="row"><span>Date</span><span>{{ $date_paiement }}</span></div>
    <div class="row"><span>Mode</span><span>{{ $mode_paiement }}</span></div>

    <hr>

    <div class="row">
        <strong>Montant</strong>
        <strong>{{ $montant }} FCFA</strong>
    </div>

    <div class="actions">
        <button class="print" onclick="window.print()">🖨️ Imprimer</button>

        <form action="{{ route('recu.pdf') }}" method="POST">
            @csrf
            @foreach(request()->all() as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <button class="pdf">📄 PDF</button>
        </form>
    </div>
</div>

</body>
</html>
