<?php
include("connessione.php"); // Includi il file di connessione al database
global $conn;

$barbiere = $_POST["barbiere"];
$data_selezionata = $_POST["dataSelezionata"];

// Inizializza le variabili per le tue tabelle e colonne specifiche
$appuntamenti = "";
$idAppuntamento = "";

if ($barbiere == "kevin") {
    $appuntamenti = "appuntamentikevin";
    $idAppuntamento = "idAppuntamentoK";
} elseif ($barbiere == "diego") {
    $appuntamenti = "appuntamentidiego";
    $idAppuntamento = "idAppuntamentoD";
}

// Funzione per verificare la disponibilità di un turno
function verificaDisponibilita($data, $ora) {
    global $conn, $appuntamenti, $idAppuntamento;

    $query = "SELECT COUNT($idAppuntamento) AS count FROM $appuntamenti WHERE data = '$data' AND ora = '$ora'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $numero_appuntamenti = intval($row["count"]);

        // Verifica se il turno è occupato o disponibile
        if ($numero_appuntamenti === 0) {
            return "Disponibile";
        } else 
		{
            return "Occupato";
        }
    } else {
        // Gestisci eventuali errori durante l'esecuzione della query
        return "Errore nella query: " . mysqli_error($conn);
    }
}

$orari = array(
    '08:30:00',
    '09:00:00',
    '09:30:00',
    '10:00:00',
    '10:30:00',
    '11:00:00',
    '11:30:00',
    '12:00:00',
    '15:00:00',
    '15:30:00',
    '16:00:00',
    '16:30:00',
    '17:00:00',
    '17:30:00',
    '18:00:00',
    '18:30:00',
    '19:00:00',
);

$turni_disponibili = array();

foreach ($orari as $ora) 
{
    $disponibilita = verificaDisponibilita($data_selezionata, $ora);
    if ($disponibilita === "Disponibile") 
	{ 
    $turni_disponibili[] = $ora; // Aggiungi l'ora all'array
	}

	else
	{
	}
}

header('Content-Type: application/json');
echo json_encode($turni_disponibili);
?>
