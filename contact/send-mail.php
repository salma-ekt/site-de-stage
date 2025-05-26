<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['website'])) {
        http_response_code(400);
        echo "Spam détecté.";
        exit;
    }

    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Veuillez remplir correctement le formulaire.";
        exit;
    }

    $to = "sessaktany@gmail.com";
    $subject = "Nouveau message de $name via formulaire de contact";
    $body = "Nom : $name\nEmail : $email\n\nMessage :\n$message\n";

    $headers = "From: $name <$email>\r\nReply-To: $email\r\n";

    if (mail($to, $subject, $body, $headers)) {
        echo "Merci pour votre message, je vous répondrai rapidement.";
    } else {
        http_response_code(500);
        echo "Erreur lors de l'envoi du message.";
    }
} else {
    http_response_code(403);
    echo "Méthode non autorisée.";
}
?>
