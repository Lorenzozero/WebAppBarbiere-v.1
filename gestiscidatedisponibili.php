<?php
include("connessione.php"); // Includi il file di connessione al database
global $conn;
$barbiere = $_POST["barbiere"]; // Recupera il valore del parametro POST "barbiere"

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

$date_disponibili = array(); // Questo array conterrà le date disponibili

// Ottieni tutte le date visualizzate nel calendario (ad esempio, 30 giorni avanti dalla data odierna)
$date_visualizzate = array();
$data_corrente = new DateTime();
for ($i = 0; $i < 30; $i++) 
{
    $date_visualizzate[] = $data_corrente->format("d-m-Y");
    $data_corrente->add(new DateInterval('P1D')); // Aggiunge un giorno alla data corrente
}

// Esegui la query per contare il numero di appuntamenti per ogni data visualizzata
foreach ($date_visualizzate as $data) {
    $query_count = "SELECT COUNT($idAppuntamento) AS count FROM $appuntamenti WHERE data = '$data'";
    $result_count = mysqli_query($conn, $query_count);

    if ($result_count) {
        $row_count = mysqli_fetch_assoc($result_count);
        $numero_appuntamenti = intval($row_count["count"]);

        // Se ci sono meno di 16 appuntamenti per questa data, la consideriamo disponibile
        if ($numero_appuntamenti < 16) 
		{
            // Formatta la data nel formato "d-m-Y" prima di aggiungerla all'array
            $data_formattata = DateTime::createFromFormat('d-m-Y', $data);
            if ($data_formattata) 
			{
                $date_disponibili[] = $data_formattata->format('d-m-Y'); // Aggiunge la data disponibile all'array
            }
        }
		else
		{
          // $date_nulla = "00-00-0000";
		  // $date_disponibili[] = $date_nulla; // Aggiunge la data disponibile all'array
			
		}
    } 
	else 
	{
        // Gestisci eventuali errori durante l'esecuzione della query
        echo "Errore nella query: " . mysqli_error($conn);
    }
}

// Verifica se ci sono date disponibili
if (empty($date_disponibili)) {
    header('Content-Type: application/json');
    echo json_encode(array("message" => "Nessuna data disponibile"));
} else {
    header('Content-Type: application/json');
    echo json_encode($date_disponibili); // Restituisce le date disponibili in formato JSON
}

// Chiudi la connessione al database
mysqli_close($conn);
?>
