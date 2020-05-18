<?php 
     //me connecte à la base de donnée 
    //crée notre variable $pdo 
    include("db.php");


    //pour débugguer les données envoyées du formulaire
    //var_dump($_POST);
    //par défaut, on dit que le formulaire est entièrement valide
    //si on trouve ne serait-ce qu'une seule erreur, on 
    //passera cette variable à false
    if(!empty($_POST)){
    
        $formIsValid = true;   
        $firstname_lastname = strip_tags($_POST['firstname_lastname']);
        $email = strip_tags($_POST['email']);
        $entreprise  = strip_tags($_POST['entreprise']);
        $adresse = strip_tags($_POST['adresse']);
        $ville  = strip_tags($_POST['ville']);
        $cp  = strip_tags($_POST['cp']);
        $poste = strip_tags($_POST['poste']);
        $commentaire  = strip_tags($_POST['commentaire']);
         
    //tableau qui stocke nos éventuels messages d'erreur
    $errors = [];

      //si le firstname_lastname est vide...
    if(empty($cp) ){
      //on note qu'on a trouvé une erreur ! 
      $errors[] = "Veuillez renseigner votre code postal";
  }
  //mb_strlen calcule la longueur d'une chaîne
  elseif(mb_strlen($cp) <= 4){
      $errors[] = "le CP est trop court !";
  }
  elseif(mb_strlen($cp) > 5){
      $errors[] = "le CP est trop long !";
  }

    //si le firstname_lastname est vide...
    if(empty($firstname_lastname) ){
        //on note qu'on a trouvé une erreur ! 
        $errors[] = "Veuillez renseigner votre nom de famille !";
    }
    //mb_strlen calcule la longueur d'une chaîne
    elseif(mb_strlen($firstname_lastname) <= 1){
        $errors[] = "Votre nom de famille est court, très court. Veuillez le rallonger !";
    }
    elseif(mb_strlen($firstname_lastname) > 30){
        $errors[] = "Votre nom de famille est trop long !";
    }

    //validation de l'email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Votre email n'est pas valide !";
    }
    //si le poste est vide...
    if(empty($poste) ){
        //on note qu'on a trouvé une erreur ! 
        $errors[] = "Veuillez renseigner votre poste !";
    }
    //mb_strlen calcule la longueur d'une chaîne
    elseif(mb_strlen($poste) <= 1){
        $errors[] = "Votre nom de poste est court, très court. Veuillez le rallonger !";
    }
    elseif(mb_strlen($poste) > 30){
        $errors[] = "Votre nom de poste est trop long !";
    }
    //si l'entreprise est vide...
    if(empty($entreprise) ){
        //on note qu'on a trouvé une erreur ! 
        $errors[] = "Veuillez renseigner votre entreprise !";
    }
    //mb_strlen calcule la longueur d'une chaîne
    elseif(mb_strlen($entreprise) <= 1){
        $errors[] = "Votre nom d'entreprise est court, très court. Veuillez le rallonger !";
    }
    elseif(mb_strlen($entreprise) > 30){
        $errors[] = "Votre nom d'entreprise est trop long !";
    }
    //si l'adresse est vide...
    if(empty($ville) ){
        //on note qu'on a trouvé une erreur ! 
        $errors[] = "Veuillez renseigner votre adresse !";
    }
    //mb_strlen calcule la longueur d'une chaîne
    elseif(mb_strlen($ville) <= 2){
        $errors[] = "Votre adresse est courte, très courte. Veuillez le rallonger !";
    }
    elseif(mb_strlen($ville) > 50){
        $errors[] = "Votre adresse est trop longue !";
    }
    //si le commentaire est vide...
    if(empty($commentaire) ){
        //on note qu'on a trouvé une erreur ! 
        $errors[] = "Veuillez renseigner votre commentaire !";
    }
    //mb_strlen calcule la longueur d'une chaîne
    elseif(mb_strlen($commentaire) <= 10){
        $errors[] = "Votre commentaire est court, très court. Veuillez le rallonger !";
    }
    elseif(mb_strlen($commentaire) > 1200){
        $errors[] = "Votre commentaire est trop long !";
    }

    //affiche les éventuelles erreurs de validations
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div>' . $error . '</div>'    ;
        }
    }
    //si le formulaire est toujours valide... 
    if (empty($errors)) {
    //on écrit tout d'abord notre requête SQL, dans une variable
    $sql = "INSERT INTO users 
            (firstname_lastname, email, entreprise, adresse, ville, cp, poste, commentaire, date_created)
            VALUES 
            (:firstname_lastname, :email, :entreprise, :adresse, :ville, :cp, :poste, :commentaire, NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":firstname_lastname" => $firstname_lastname, 
        ":email" => $email,
        ":entreprise" => $entreprise,
        ":adresse" => $adresse,
        ":ville" => $ville,
        ":cp" => $cp,
        ":poste" => $poste, 
        ":commentaire" => $commentaire
    ]);
    }
    
}
                        
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="contact.css" type="text/css" media="screen"/>
    <link href="https://fonts.googleapis.com/css?family=Kanit|Permanent+Marker|Source+Code+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Jim+Nightshade&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Calligraffitti&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Patrick+Hand&display=swap" rel="stylesheet">
    <title>Contact</title>
</head>

<body>

<h1 class="titre_page" style="padding-top:3%">Contact</h1>
    <nav class="navbar fixed-top" style="display:flex; font-weight: bold;">
        <p><a class="navbar-brand" href="index.php"><img src="../src/img/icone_home.png"></img> Home</a><p>
        <p><a class="navbar-brand" href="cv.html"><img src="../src/img/icone_cv.png"></img> Mon Cv</a><p>
        <p><a class="navbar-brand" href="projet.html"><img src="../src/img/icone_livre.png"></img> Mes projets</a></p>
      </nav>

<div class="formulaire">
  <form method="post">
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="firstname_lastname">Nom, Prénom</label>
        <input id="firstname_lastname" name="firstname_lastname"  type="text" class="form-control"  placeholder="Ex: Jacques Mesrine">
      </div>
      <div class="form-group col-md-6">
        <label for="email">Email</label>
        <input id="email" name="email"  type="email" class="form-control">
      </div>
      
      <div class="form-group col-md-6">
        <label for="poste">Poste occupé</label>
        <input id="poste" name="poste"  type="text" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <label for="entreprise">Nom de l'entreprise</label>
      <input id="entreprise" name="entreprise"  type="text" class="form-control" placeholder="Ex: Tesla..">
    </div>
    <div class="form-group">
      <label for="adresse">Adresse</label>
      <input id="adresse" name="adresse"  type="text" class="form-control">
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="ville">Ville</label>
        <input id="ville" name="ville"  type="text" class="form-control">
      </div>
      <div class="form-group col-md-2">
        <label for="cp">CP</label>
        <input id="cp" name="cp"  type="text" class="form-control">
      </div>
    </div>
    <!-- -- Commentaire ---->
    <div class="form-group">
      <label for="commentaire">Commentaires</label>
      <textarea type="text" class="form-control" id="commentaire" name="commentaire"  placeholder="Ex: Très gentil ce jeune homme !.. " rows="5" value="" required></textarea>
      <div class="invalid-feedback">
      Ajoutez un commentaire valide!
      </div>
  </div>
    <div class="form-group">
    <button type="submit" class="btn btn-primary">Publier la recommandation</button>
  </form>
</div>
</div>

<footer>
<p style="text-align: center; padding-top: 40px; font-size:16px;"><b>&copy; 2020 Le Cam Yohan</b><p>
</footer>
</body>
</html>