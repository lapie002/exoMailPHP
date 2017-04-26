<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <title>Mail Form PHP</title>
  <link rel='stylesheet' href='styles.css' type='text/css' media='all' />
</head>
<body>
  <fieldset>
    <div id='error_page'>
      <?php

          $msg = $_GET['msg'];
          $civil = $_GET['civil'];
          $nom  = $_GET['nom'];
          
       ?>
      			<h3>Erreur ! le mail n'a pas pu etre envoyé, veuillez réessayer <a href='http://lapierre.herobo.com/' style='color:#468ACF'>en cliquant ici.</a></h3>
            <p><?php echo $msg; ?></p>
      <p>Merci <strong><?php echo "$civil $nom"; ?></strong>, votre message n'a pas été soumis à ma boite mail.</p>
      <p>pour revenir au formulaire de mail <a href='http://51.255.196.206/lapie002/' style='color:#468ACF'>cliquez ici.</a></p>
    </div>
  </fieldset>
</body>
</html>
