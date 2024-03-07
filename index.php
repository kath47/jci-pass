<!DOCTYPE html>
<html lang="fr"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Ticket célébration JCI</title> 
    <script src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css"></script> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">  
    <link rel="stylesheet" type="text/css" href="./style_home.css">
</head>
<body>

<div class="container w-50 mt-5">
    <div class="card align-self-center border-success">
        <div class="card-header">
            <h3 class="card-title text-center">Célébration des 35 ans de la JCI</h3>
            <p>Veuillez vous inscrire pour obtenir un ticket</p>
        </div>
        <div class="card-body">
            <form class="" method="post" action="qrcode.php">
                <div class="form-group">
                    <label >Nom & prénoms</label>
                    <input type="text" name="qrtext" id="qrtext" class="form-control" required data-parsley-pattern="[A-Z]+" data-parsley-trigger="keyup"
                    oninput="this.value = this.value.toUpperCase();" maxlength="30" onkeyup="this.value=this.value.toUpperCase()">
                </div>
                <div class="form-group">
                    <label >Email</label>
                    <input type="email" name="qremail" id="qremail" class="form-control" required>
                </div>
                <div class="form-group">
                    <label >Téléphone</label>
                    <input type="tel" name="qrphone" id="qrphone" class="form-control" data-parsley-pattern="[0-9]+" required>
                </div>
                <div class="d-grid gap-2 col-8 mx-auto">
                <input type="submit" name="sbt-btn" value="Générer votre ticket" class="btn btn-success mt-3">
                </div>
            </form>
        </div>
    </div>
    <p class="center">Copyright © 2024 - Athanase Kouassi - Tous droits reservés</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </script>
 </body>  
</html>  

