<?php 
require 'connessione.php';
require __DIR__ .'/ComposerSetup/vendor/autoload.php';

use Mailgun\Mailgun;
/*
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Genera un codice di conferma casuale
    $codiceConferma = bin2hex(random_bytes(16));

    // Salva il codice di conferma nel database associato all'indirizzo email
    $query = "UPDATE utenti SET codice_conferma = '$codiceConferma' WHERE email = '$email'";

    if (mysqli_query($conn, $query)) {
        // Inizializza l'oggetto Mailgun con la tua API key e il dominio
        $mg = Mailgun::create('3750a53b-facac8ac');
        $domain = 'sandbox2fd7c72c489a4bb0b33f28c2ed7392ff.mailgun.org'; // Sostituisci con il tuo dominio Mailgun

        // Costruisci il tuo messaggio HTML
        $message = '<html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #333;
                        text-align: center;
                        color: white;
                    }
                    h1 {
                        font-size: 36px;
                        margin-top: 0;
                    }
                    p {
                        font-size: 16px;
                        line-height: 1.5;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: rgba(255, 255, 255, 0.2);
                        padding: 20px;
                        border-radius: 5px;
                    }
                    .code-container {
                        background-color: rgba(255, 255, 255, 0.2);
                        padding: 10px;
                        border-radius: 5px;
                    }
                    form {
                        margin-top: 20px;
                    }
                    input[type="hidden"] {
                        display: none;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>Reset Password</h1>
                    <p>Per completare il reset della password, inserisci il seguente codice nel campo apposito:</p>
                    <div class="code-container">
                        Codice di Conferma: ' . $codiceConferma . '
                    </div>
                    <form method="post" action="pagina_reset_password.php">
                        <input type="hidden" name="codice_conferma" value="' . $codiceConferma . '">
                    </form>
                </div>
            </body>
        </html>';

        // Invia l'email utilizzando Mailgun
        $mg->messages()->send($domain, [
            'from'    => 'Diego\'s Barbershop <diegobarbershop@diegobarber.it>', // Sostituisci con l'indirizzo email del mittente
            'to'      => $email,
            'subject' => 'Conferma Codice di Reset Password',
            'html'    => $message,
        ]);

        // Redirect l'utente alla pagina di conferma del codice
        header("Location: confermaCodice.php");
    } else {
        echo "Errore nell'invio del codice di conferma.";
    }
}*/
$mg = Mailgun::create('3750a53b-facac8ac');
$domain = 'sandbox2fd7c72c489a4bb0b33f28c2ed7392ff.mailgun.org';

$apiKeyInfo = $mg->get("$domain/credentials");
echo json_encode($apiKeyInfo);

?>
