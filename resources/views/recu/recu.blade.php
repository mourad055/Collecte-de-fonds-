<?php
if(!isset($_POST['nom'], $_POST['montant'], $_POST['mode'])){
    die("Accès non autorisé");
}

$nom = htmlspecialchars($_POST['nom']);
$montant = intval($_POST['montant']);
$mode = htmlspecialchars($_POST['mode']);
$date = date("d/m/Y");
$numero = "REC-" . rand(10000,99999);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Reçu de Paiement</title>
<style>
body{
    background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    font-family:Poppins,sans-serif;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}
.card{
    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(12px);
    padding:30px;
    border-radius:20px;
    width:420px;
    color:#fff;
}
.btn{
    margin-top:25px;
    display:block;
    text-align:center;
    padding:14px;
    background:linear-gradient(135deg,#ffb347,#ffcc33);
    border-radius:30px;
    color:#000;
    text-decoration:none;
    font-weight:bold;
}
</style>
</head>
<body>

<div class="card">
    <h2 style="text-align:center">REÇU DE PAIEMENT</h2>

    <p><b>Numéro :</b> <?= $numero ?></p>
    <p><b>Client :</b> <?= $nom ?></p>
    <p><b>Date :</b> <?= $date ?></p>
    <p><b>Mode :</b> <?= $mode ?></p>

    <h3 style="text-align:center"><?= number_format($montant,0,' ',' ') ?> FCFA</h3>

    <a class="btn" href="generate_pdf.php?
        nom=<?= urlencode($nom) ?>&
        montant=<?= $montant ?>&
        mode=<?= urlencode($mode) ?>&
        date=<?= $date ?>&
        numero=<?= $numero ?>">
        Télécharger le reçu PDF
    </a>
</div>

</body>
</html>