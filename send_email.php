<?php

if(!$_POST) exit;

		// Email address verification, do not edit.
		function isEmail($email) {
			return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
		}

		$civilite = $_POST['civilite'];
		$name     = $_POST['nom'];
		$email    = $_POST['email'];
		$subject  = $_POST['sujet'];
		$message  = $_POST['message'];

		// message erreur pour le formulaire
		if(trim($name) == '') {
			echo '<div class="error_message">Vous devez entrer votre nom et prenom.</div>';
			exit();
		} else if(trim($email) == '') {
			echo '<div class="error_message">Vous devez entrer une adresse mail valide.</div>';
			exit();
		} else if(!isEmail($email)) {
			echo '<div class="error_message">Vous avez entré une adresse mail invalide. Veuillez réessayer.</div>';
			exit();
		}
		if(trim($message) == '') {
			echo '<div class="error_message">Vous devez taper votre message avant de l\'envoyer.</div>';
			exit();
		}
		if(get_magic_quotes_gpc()) {
			$message = stripslashes($message);
		}

		//$mailto = 'lapierre.bruno@outlook.com';
		$mailto = 'pbelaire@simplon.co';

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
		$headers .= "Bcc: nvilla@simplon.co, $email" . $eol;
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
		function sendMyEmail($m, $s, $b, $h) {
			  if(mail($m, $s, $b, $h)){
						echo "success";
				}
		    else{
		        throw new Exception("Mail failed to be sent, zéro c'est nul ca marche pas !!!");
		    }
		}


		try{

			sendMyEmail($mailto, $subject, $body, $headers);
			header('Location: http://51.255.196.206/lapie002/send_mail_success.php?civil=' . $civilite . '&nom=' . $name );

		}catch (Exception $e){
			$errormsg = $e->getMessage();
      header('Location: http://51.255.196.206/lapie002/send_mail_success.php?msg=' . $errormsg);
			//echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}


		/*
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
   */


?>
