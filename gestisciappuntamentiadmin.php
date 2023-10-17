<?php
include("connessione.php"); // Includi il file di connessione al database
global $conn;
if (isset($_POST['User'])) {
    $idUtente = $_POST['User'];
	 echo $idUtente;
} else {
    $idUtente = null; // O un valore predefinito
	    //  header('Location: login.php');
			 echo $idUtente;

}

// Ora $idUtente conterrà il valore selezionato dall'utente

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];
    $time = $_POST["time"];
    $services = isset($_POST["services"]) ? implode(", ", $_POST["services"]) : ""; // Trasforma i servizi selezionati in una stringa separata da virgole
    $barbiere = $_POST["barbiere"];

    // Verifica se il barbiere selezionato è "diego"
    if ($barbiere === "diego") {
        $tableName = "appuntamentidiego"; // Tabella per Diego
    } else {
        $tableName = "appuntamentikevin"; // Tabella per Kevin (o qualsiasi altro barbiere)
    }

    // Controlla se l'appuntamento esiste già nella tabella selezionata
    $sqlCheck = "SELECT * FROM $tableName WHERE idUtenti = '$idUtente'";
    $resultCheck = $conn->query($sqlCheck);

    if ($resultCheck->num_rows > 0) {
        // L'appuntamento esiste nella tabella, quindi aggiorna i dati
        $sqlUpdate = "UPDATE $tableName SET servizi = '$services', data = '$date', ora = '$time' WHERE idUtenti = '$idUtente'";
    } else {
        // L'appuntamento non esiste nella tabella, quindi crea un nuovo appuntamento
        $sqlUpdate = "INSERT INTO $tableName (data, ora, servizi, idUtenti, barbiere) VALUES ('$date', '$time', '$services', '$idUtente', '$barbiere')";
    }

    if ($conn->query($sqlUpdate) === TRUE) {
        echo "L'appuntamento è stato aggiornato con successo nella tabella $tableName";
    } else {
        echo "Si è verificato un errore durante l'aggiornamento/inserimento: " . $conn->error;
    }

    // Chiudi la connessione al database
    $conn->close();

    // Reindirizza l'utente alla pagina "profilo.php" dopo l'elaborazione
    header("Location: appuntamenti.php");
    exit; // Assicura che il codice successivo non venga eseguito
}
?>
