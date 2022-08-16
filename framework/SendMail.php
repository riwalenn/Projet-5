<?php

class SendMail
{
    public function sendToken($array, $type)
    {
        if (empty($array)) :
            echo "Le token ou l'email sont manquants !";

            return false;
        endif;

        foreach ($array as $user) {
                $email = strip_tags(htmlspecialchars($user->getEmail()));
                $token = strip_tags(htmlspecialchars($user->getToken()));

                if ($type == 'inscription') :
                    $sujet = "Confirmation de votre inscription sur le blog de Riwalenn Bas";
                    $message = "Pour confirmer votre inscription, veuillez cliquer sur le lien ci-dessous :\n\n" . Constantes::HTTP_RIWALENN . "/index.php?action=confirmationInscriptionByEmail&token=$token";
                //$message = "Pour confirmer votre inscription, veuillez cliquer sur le lien ci-dessous :\n\nhttps://projet5.riwalennbas.com/index.php?action=confirmationInscriptionByEmail&token=$token";

                elseif ($type == 'password') :
                    $sujet = "Modification de mon mot de passe sur le blog de Riwalenn Bas";
                    $message = "Pour modifier votre mot de passe, veuillez cliquer sur le lien ci-dessous :\n\n" . Constantes::HTTP_RIWALENN . "/index.php?action=iForgotMyPassword&token=$token";
                    //$message = "Pour modifier votre mot de passe, veuillez cliquer sur le lien ci-dessous :\n\nhttps://projet5.riwalennbas.com/index.php?action=iForgotMyPassword&token=$token";
                endif;

                $to = $email;
                $email_subject = "$sujet";
                $email_body = "$message";
                $headers = "From: noreply@riwalennbas.com\n";
                $headers .= "Reply-To: $email";
                mail($to, $email_subject, $email_body, $headers);
        }

        return true;
    }
}