<?php
// Check for empty fields
if (empty($_REQUEST['name']) || empty($_REQUEST['email']) || empty($_REQUEST['sujet']) || empty($_REQUEST['message']) || !filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
    echo "Certains champs sont vides";

    return false;
}

$name = strip_tags(htmlspecialchars(filter_input(INPUT_POST, 'name')));
$email_address = strip_tags(htmlspecialchars(filter_input(INPUT_POST, 'email')));
$sujet = strip_tags(htmlspecialchars(filter_input(INPUT_POST, 'sujet')));
$message = strip_tags(htmlspecialchars(filter_input(INPUT_POST, 'message')));


$to = 'hello@riwalennbas.com';
$email_subject = "$sujet:  $name";
$email_body = "Vous avez reçu un email depuis votre blog.\n\nDétails du message ci-dessous :\n\nName: $name\n\nEmail: $email_address\n\nMessage:\n$message";
$headers = "From: noreply@riwalennbas.com\n";
$headers .= "Reply-To: $email_address";
mail($to, $email_subject, $email_body, $headers);

return true;
?>