<?php
    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = strip_tags(trim($_POST["name"]));
		$name = str_replace(array("\r","\n"),array(" "," "),$name);
		$vorname = strip_tags(trim($_POST["vorname"]));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $strasse = strip_tags(trim($_POST["strasse"]));
        $plz = strip_tags(trim($_POST["plz"]));
        $tel = strip_tags(trim($_POST["tel"]));
        $kommentar = strip_tags(trim($_POST["kommentar"]));

        // Check that data was sent to the mailer.
        if ( empty($vorname)) {
            http_response_code(400);
            echo "Bitte füllen Sie alle Felder, welche mit einem Stern gekennzeichnet sind, aus.";
            exit;
        }
        if ( empty($name)) {
            http_response_code(400);
            echo "Bitte füllen Sie alle Felder, welche mit einem Stern gekennzeichnet sind, aus.";
            exit;
        }
        if ( empty($kommentar)) {
            http_response_code(400);
            echo "Bitte füllen Sie alle Felder, welche mit einem Stern gekennzeichnet sind, aus.";
            exit;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo "Ihre E-Mail-Adresse ist nicht korrekt.";
            exit;
        }

        $recipient = "info@zhm-living.ch";
        $subject = "New contact from $name";

        $email_content =  "Vorname: $vorname\n";
        $email_content .=  "Name: $name\n";
        $email_content .= "Strasse:$strasse\n";
        $email_content .= "PLZ/Ort:$plz\n";
        $email_content .= "Tel:$tel\n";
        $email_content .= "Email:$email\n";
        $email_content .= "Kommentar:\n$kommentar";

        $email_headers = "From: $name <$email>";

        if (mail($recipient, $subject, $email_content, $email_headers)) {
            http_response_code(200);
            echo "Herzlichen Dank für Ihre Kontaktaufnahme. Sie werden in Kürze von uns hören.";

            // send auto response
            try {
                $autorespondertext = file_get_contents("autoresponse.html");
                $headers = "From: ZHM Living <info@zhm-living.ch>\r\n";
                $headers .= "Content-type:  text/html\r\n";
                mail($email, "Ihre Anfrage", $autorespondertext, $headers);
            } catch (Exception $e) {
                // no auto responder - no real problem
            }
        } else {
            http_response_code(500);
            echo "Ihre Nachricht konnte nicht gesendet werden.";
        }

    } else {
        http_response_code(403);
        echo "Ihre Nachricht konnte nicht gesendet werden.";
    }

?>
