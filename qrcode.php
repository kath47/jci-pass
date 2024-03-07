
<?php
require_once 'connection.php';
require_once 'phpqrcode/qrlib.php';

$path = './images/';
$timestamp = time();
$qrcode = $path . $timestamp . ".png";

if(isset($_REQUEST['sbt-btn']))
{
    $qrtext = $_REQUEST['qrtext'];
    $qremail = $_REQUEST['qremail'];
    $qrphone = $_REQUEST['qrphone'];

    // Échapper les données pour éviter les injections SQL
    $qrtext = mysqli_real_escape_string($connection, $qrtext);
    $qremail = mysqli_real_escape_string($connection, $qremail);
    $qrphone = mysqli_real_escape_string($connection, $qrphone);

    // Vérifier si le participant est déjà inscrit
    $check_query = "SELECT COUNT(*) AS count FROM qrcode WHERE qremail = '$qremail'";
    $check_result = $connection->query($check_query);
    $row = $check_result->fetch_assoc();
    $participant_count = $row['count'];

    if($participant_count > 0) {
        ?>
        <script>
            alert("Vous êtes déjà inscrit pour le ticket.");
            function redirectToHomepage() {
            window.location.href = 'index.php';}
          //swal ( "Oops" ,  "Something went wrong!" ,  "error" );

        </script>
        <?php
        exit; // Sortir du script car le participant est déjà inscrit
    }

    $query = "INSERT INTO qrcode (qrtext, qremail, qrtelephone, qrimage) VALUES ('$qrtext', '$qremail', '$qrphone', '$qrcode')";

    if($connection->query($query))
    {
        ?>
        <script>
            alert("Ticket enregistré avec succès");
        </script>
        <?php

        $lastTicketID = $connection->insert_id;   // Récupérer le dernier ID inséré (numéro de ticket auto-incrémenté)
 
        $qrcodeText = "N° du Ticket: JCI-035-000$lastTicketID\nNom: $qrtext\nEmail: $qremail\nTéléphone: $qrphone"; // Concaténer les informations en une seule chaîne

        $largeur_fixe = 300; 
        $hauteur_fixe = 300;
        QRcode::png($qrcodeText, $qrcode, 'H', 2.4, 5, false, 0xFFFFFF, 0x000000, false, $largeur_fixe, $hauteur_fixe);
        //QRcode::png($qrcodeText, $qrcode,'H', 2.6, 3); // Générer le code QR

        // Rediriger vers la page ticket.php avec le nom du fichier QRCode en paramètre
        header('Location: ticket.php?qrcode=' . urlencode($qrcode));
        exit;
    } else {
        echo "Erreur lors de l'enregistrement du ticket."; // Erreur lors de l'inscription
    }
}
?>


