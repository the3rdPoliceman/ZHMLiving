<?php
    // My modifications to mailer script from:
    // http://blog.teamtreehouse.com/create-ajax-contact-form
    // Added input sanitizing to prevent injection

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
		$name = str_replace(array("\r","\n"),array(" "," "),$name);
		$vorname = strip_tags(trim($_POST["strasse"]));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $strasse = strip_tags(trim($_POST["strasse"]));
        $plz = strip_tags(trim($_POST["plz"]));
        $tel = strip_tags(trim($_POST["tel"]));
        $kommentar = strip_tags(trim($_POST["kommentar"]));

        // Check that data was sent to the mailer.
        if ( empty($vorname)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "No Vorname";
            exit;
        }
        if ( empty($name)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "No Name";
            exit;
        }
        if ( empty($kommentar)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "No Kommentar";
            exit;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Invalid email";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "info@zhm-living.ch";

        // Set the email subject.
        $subject = "New contact from $name";

        // Build the email content.
        $email_content =  "Vorname: $vorname\n";
        $email_content .=  "Name: $name\n";
        $email_content .= "Strasse:$strasse\n";
        $email_content .= "PLZ/Ort:$plz\n";
        $email_content .= "Tel:$tel\n";
        $email_content .= "Email:$email\n";
        $email_content .= "Kommentar:\n$kommentar";

        // Build the email headers.
        $email_headers = "From: $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Vielen Dank! Ihre Nachricht wurde gesendet";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Fehler! Ihre Nachricht konnte nicht gesendet werden!";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Fehler! Ihre Nachricht konnte nicht gesendet werden!";
    }

?>
