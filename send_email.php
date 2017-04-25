<?php

if(!$_POST) exit;

		$civilite = $_POST['civilite'];
		$name     = $_POST['nom'];
		$email    = $_POST['email'];
		$subject  = $_POST['sujet'];
		$message  = $_POST['message'];

		$mailto = 'lapierre.bruno@outlook.com';

		$filename = basename($_FILES["fileToUpload"]["name"]);
		// make a moveuploaded file
    $path = 'uploads';
    $file = $path . "/" . $filename;
		// On peut valider le fichier et le stocker définitivement
		move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$file);



    $content = file_get_contents($file);
    $content = chunk_split(base64_encode($content));

    // a random hash will be necessary to send mixed content
    $separator = md5(time());

    // carriage return type (RFC)
    $eol = "\r\n";

    // main header (multipart mandatory)
    $headers  = "From: $email". $eol;
		$headers .= "Reply-To: $email" . $eol;
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
    $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
    $headers .= "This is a MIME encoded message." . $eol;

    // message
    $body = "--" . $separator . $eol;
    $body .= "Content-Type: text/plain; charset=utf-8" . $eol;
    $body .= "Content-Transfer-Encoding: 8bit" . $eol;
    //$body .= $message . $eol;
		$e_body = "Vous avez été contatcté par $civilite $name, voici le message : " . $eol . $eol;
		$e_content = "\"$message\"" . $eol . $eol;
		$e_reply = "Vous pouvez contacter $civilite $name via email à cette adresse,\n" .  $email;

		$msg = wordwrap( $e_body . $e_content . $e_reply, 80 );

		$body .= $msg . $eol;


    // attachment
    $body .= "--" . $separator . $eol;
    $body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
    $body .= "Content-Transfer-Encoding: base64" . $eol;
    $body .= "Content-Disposition: attachment" . $eol;
    $body .= $content . $eol;
    $body .= "--" . $separator . "--";

    //SEND Mail
    if(mail($mailto, $subject, $body, $headers)) {
			echo "<!DOCTYPE html>";
			echo "<html>";
			echo "<head>";
			echo "<meta charset='utf-8'>";
			echo "<title>Mail Form PHP</title>";
			echo "<link rel='stylesheet' href='styles.css' type='text/css' media='all' />";
			echo "</head>";
			echo "<body>";
			echo "<fieldset>";
			echo "<div id='success_page'>";
			echo "<h3>l'email a été envoyé avec succès.</h3>";
			echo "<p>Merci <strong>$civilite $name</strong>, votre message a été soumis à ma boite mail.</p>";
			echo "<p>pour revenir au formulaire de mail <a href='http://lapierre.herobo.com/' style='color:#468ACF'>cliquez ici.</a></p>";
			echo "</div>";
			echo "</fieldset>";
			echo "</body>";
			echo "</html>";
    }
		else {
			echo "<!DOCTYPE html>";
			echo "<html>";
			echo "<head>";
			echo "<meta charset='utf-8'>";
			echo "<title>Mail Form PHP</title>";
			echo "<link rel='stylesheet' href='styles.css' type='text/css' media='all' />";
			echo "</head>";
			echo "<body>";
			echo "<fieldset>";
			echo "<div id='success_page'>";
			echo "<h3>Erreur ! le mail n'a pas pu etre envoyé, veuillez réessayer <a href='http://lapierre.herobo.com/' style='color:#468ACF'>en cliquant ici.</a></h3>";
			echo "</div>";
			echo "</fieldset>";
			echo "</body>";
			echo "</html>";
      print_r( error_get_last() );
    }

?>
