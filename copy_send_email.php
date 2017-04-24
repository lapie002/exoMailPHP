<?php

if(!$_POST) exit;

// Email address verification, do not edit.
function isEmail($email) {
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

$civilite = $_POST['civilite'];
$name     = $_POST['nom'];
$email    = $_POST['email'];
$sujet     = $_POST['sujet'];
$message = $_POST['message'];
// essaie pour la piece jointe
//$file_name  = file_get_contents($_FILES["fileToUpload"]["name"]);
$file_name = basename($_FILES["fileToUpload"]["name"]);





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

$address = "lapierre.bruno@outlook.com";
// gmail ne fonctionne pas ERROR
//$address = "lapierre.bruno@gmail.com";


// Configuration option.
// i.e. The standard subject will appear as, "You've been contacted by John Doe."
// Example, $e_subject = '$name . ' has contacted you via Your Website.';
//$e_subject = 'Vous avez été contacté par ' . $civilite .' '. $name . '.';
$e_subject = '[ ' . $sujet . ']';

// Configuration option.
// You can change this if you feel that you need to.
// Developers, you may wish to add more fields to the form, in which case you must be sure to add them here.
//     $civilite   $name       $email         $sujet            $message

$e_body = "Vous avez été contatcté par $civilite $name, voici le message : " . PHP_EOL . PHP_EOL;
$e_content = "\"$message\"" . PHP_EOL . PHP_EOL;
$e_reply = "Vous pouvez contacter $civilite $name via email à cette adresse,\n" .  $email;

$msg = wordwrap( $e_body . $e_content . $e_reply, 80 );

$headers = "From: $email" . PHP_EOL;
$headers .= "Reply-To: $email" . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
//$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-type: multipart/mixed; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

//$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;



		if(mail($address, $e_subject, $msg, $headers))
		{
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
		else
		{
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
		}


?>
