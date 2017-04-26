<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <title>Mail Form PHP</title>
  <link rel='stylesheet' href='styles.css' type='text/css' media='all' />
</head>
<body>
  <fieldset>
    <?php
        $civil = $_GET['civil'];
        $nom  = $_GET['nom'];
     ?>
    <div id='success_page'>
      <h3>l'email a été envoyé avec succès.</h3>
      <p>Merci <strong><?php echo "$civil $nom"; ?></strong>, votre message a été soumis à ma boite mail.</p>
      <p>pour revenir au formulaire de mail <a href='http://51.255.196.206/lapie002/' style='color:#468ACF'>cliquez ici.</a></p>
    </div>
  </fieldset>
</body>
</html>
