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


    $query = mysqli_query($connection, "INSERT INTO qrcode (qrtext, qremail, qrtelephone, qrimage) VALUES ('$qrtext', '$qremail', '$qrphone', '$qrcode')");

    if($query)
    {
        // Récupérer le dernier ID inséré (numéro de ticket auto-incrémenté)
        $lastTicketID = mysqli_insert_id($connection);
        ?>
        <script>
            alert("Ticket enregistré avec succès");
        </script>
        <?php
    }

    // Concaténer les informations en une seule chaîne
    $qrcodeText = "N° du Ticket: JCI-035-000$lastTicketID\nNom: $qrtext\nEmail: $qremail\nTéléphone: $qrphone";
}

// Générer le code QR
QRcode::png($qrcodeText, $qrcode,'H', 2.4, 3);

// Rediriger vers la page ticket.php avec le nom du fichier QRCode en paramètre
header('Location: ticket.php?qrcode=' . urlencode($qrcode));
exit;
?>
