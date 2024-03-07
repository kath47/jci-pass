<?php
// Connexion à la base de données
require_once 'connection.php';
require_once 'phpqrcode/qrlib.php';

$sql = "SELECT id, qrtext, qremail, qrtelephone, qrimage FROM qrcode ORDER BY id DESC LIMIT 1";

$result = $connection->query($sql);

if ($result->num_rows > 0) {
    
    $ticketData = $result->fetch_assoc();
    $backgroundImagePath = './images/billet.png'; // Chemin vers l'image de fond du ticket
    $backgroundImage = imagecreatefrompng($backgroundImagePath); // Charger l'image de fond du ticket

//----------------------------Nom du participant sur l'image-------------------------------
    
    $policePath = './phpqrcode/FUTURAM.ttf'; // Chemin vers la police TrueType pour le texte
    $couleurTexte = imagecolorallocate($backgroundImage, 0, 0, 0); // Couleur du texte
    $nomParticipant = $ticketData['qrtext'];// Nom du participant ajouter 
    $xTexte = 30;   // Position horizontale à partir de la gauche
    $yTexte = 200; // Position verticale à partir du haut
    $taillePolice = 20; // Taille de la police 
    $angle = 0;  // Angle de rotation du texte (0 pour aucun)

    imagettftext($backgroundImage, $taillePolice, $angle, $xTexte, $yTexte, $couleurTexte, $policePath, $nomParticipant); // Ajouter le texte à l'image de fond

//------------------------------------------------------------------------------------------
    
    $qrCodeImagePath = $ticketData['qrimage']; // Chemin vers l'image du code QR
    $qrCodeImage = imagecreatefrompng($qrCodeImagePath); // Charger l'image du code QR

    // Obtenir les dimensions de l'image de fond
    $backgroundWidth = imagesx($backgroundImage);
    $backgroundHeight = imagesy($backgroundImage);

    // Obtenir les dimensions de l'image du code QR
    $qrCodeWidth = imagesx($qrCodeImage)*1.09;
    $qrCodeHeight = imagesy($qrCodeImage);

    // Coordonnées pour placer le code QR au centre de l'image de fond 
    $x = $backgroundWidth - $qrCodeWidth; // À droite
    $y = $backgroundHeight - $qrCodeHeight; // En bas
    imagecopy($backgroundImage, $qrCodeImage, $x, $y, 0, 0, $qrCodeWidth, $qrCodeHeight); // Fusionner l'image de fond avec l'image du code QR
     
    // Sauvegarder l'image finale sur le serveur et Libérer la mémoire
    $outputImage = './images/ticket_'.$ticketData['id'].'.jpg';
    imagejpeg($backgroundImage, $outputImage);

    imagedestroy($backgroundImage);
    imagedestroy($qrCodeImage);
} else {
    echo "Aucun enregistrement trouvé dans la table qrcode.";
}

// Fermer la connexion
$connection->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class=" col-md-12">
<div class="card mb-3" style="width: 90%; margin: 0 auto;">
  <div class="card-body" style="width: 450px;">
        <h2 class="card-title">Ticket n° : JCI-035-000<?php echo $ticketData['id']; ?></h2>
        <p class="card-text"><strong>Téléphone:</strong> <?php echo $ticketData['qrtelephone']; ?></p>
        <p class="card-text"><strong>Participant:</strong> <?php echo $ticketData['qrtext']; ?></p>
        <h6 class="card-text" style="color:red">Veuillez télécharger votre ticket Merci !!!</h6>
  </div>
  <img src="<?php echo $outputImage; ?>" class="img-fluid rounded" alt="Qr code du ticket" width="450" height="200" style="border: 1px solid black">
</div>
   
 <div class="d-grid gap-2 col-4 mx-auto text-center"  style="border:none">
     <a href="<?php echo $outputImage; ?>" id="downloadLink" class="btn btn-outline-light mt-2" download onclick="redirectToHomepage()">Télécharger</a>
     
     <script>// Rediriger vers la page d'index après 3 secondes
      function redirectToHomepage() { 
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 3000); // 3000 millisecondes (3 secondes)
      }
     </script>
 </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
     integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

     <footer class="text-center">
     <p class="align-self-center mt-3">Copyright © 2024 - Athanase Kouassi - Tous droits reservés</p>
     </footer>
     
</body>
</html>
     






