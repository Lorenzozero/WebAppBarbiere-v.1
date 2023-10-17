<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        // Mostra la notifica di successo e ricarica la pagina dopo 2 secondi
        setTimeout(function () {
            var successNotification = document.getElementById("success-notification");
            if (successNotification) {
                successNotification.style.display = "block";
                setTimeout(function () {
                    window.location.href = "profilo.php";
                }, 2000); // Attendi 2 secondi prima di ricaricare
            }
        }, 0); // Attendi un breve istante prima di eseguire questo script
    </script>
</head>
<?php
include 'connessione.php'; // Includi il file di connessione al database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera i dati dal modulo di registrazione
    $nome = mysqli_real_escape_string($conn, $_POST['Nome']);
    $cognome = mysqli_real_escape_string($conn, $_POST['Cognome']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
	$Ntelefono = mysqli_real_escape_string($conn, $_POST['nTelefono']);
    $password1 = mysqli_real_escape_string($conn, $_POST['Password']);
    $password = password_hash($password1, PASSWORD_DEFAULT); // Crittografa la password

    // Esegui una query di inserimento per aggiungere il nuovo account utente alla tabella 'utenti'
    $query = "INSERT INTO utenti (nome, cognome, email, password,nTelefono) VALUES ('$nome', '$cognome', '$email', '$password',$Ntelefono)";
    if ($conn->query($query) === TRUE) {
    echo '<div id="success-notification">account creato  con successo!</div>';
    } else {
        echo "Errore nella creazione dell'account: " . $conn->error;
    }
    $conn->close();
}
?>
</html>