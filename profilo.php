<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo Utente</title>
    <style>
        /* Stile CSS come precedentemente fornito */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: white;
            background-color: #333; /* Cambia il colore di sfondo */
        }

        .modifica-button {
            background-color: white;
            color: black;
            padding: 10px 20px;
            border: 2px solid black;
            border-radius: 5px;
            text-decoration: none;
        }

        .modifica-button:hover {
            background-color: black;
            color: white;
        }

        header {
            background-color: #111; /* Cambia il colore di sfondo */
            color: #fff;
            padding: 0px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h1 {
            font-size: 28px; /* Aumenta la dimensione del titolo */
            margin-right: auto; /* Sposta il titolo a sinistra */
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin-right: 10px; /* Aumenta la spaziatura tra i link del menu */
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            padding: 10px 20px; /* Aumenta il padding per rendere i link più grandi */
            border: 2px solid #fff;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s; /* Aggiunge transizioni per effetti hover */
        }

        nav ul li a:hover {
            background-color: #fff;
            color: #111; /* Cambia il colore del testo durante l'hover */
        }

        main {
            padding: 20px;
        }

        section {
            margin-bottom: 40px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Stile specifico per la pagina del profilo */
        .profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-info {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            padding: 20px;
            max-width: 400px;
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-appointment {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            padding: 20px;
            max-width: 400px;
            text-align: center;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cancel-button {
            background-color: #ff0000;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
        }
    </style>
	<?php
session_start();

// Verifica se l'utente è loggato
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Utente non loggato, reindirizza alla pagina di login
    header('Location: login.php');
    exit; // Assicura che lo script si interrompa dopo il reindirizzamento
}
$idUtente=($_SESSION['idUtente']);
// L'utente è loggato, continua con il resto del codice
?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <h1>Profilo</h1>
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="prenota.php">Prenota</a></li>
            <li><a href="https://wa.me/+39 349 867 7859?text=Buongiorno,%20vorrei%20chiarire%20alcune%20informazioni">Contatta</a></li>
        </ul>
    </nav>
</header>

<main>

    <section>
        <h2>Informazioni personali</h2>
        <div class="profile-container">
            <div class="profile-info">
                <?php
                include 'connessione.php';
                $sql = "SELECT nome, cognome, nTelefono, email FROM utenti WHERE idUtente = $idUtente";
                $result = $conn->query($sql);
                if ($result !== false && $result->num_rows > 0) {
                    // Output dei dati dell'utente
                    $row = $result->fetch_assoc();
                    echo "<p>Nome: " . $row["nome"] . "</p>";
                    echo "<p>Cognome: " . $row["cognome"] . "</p>";
                    echo "<p>Numero di telefono: " . $row["nTelefono"] . "</p>";
                    echo "<p>Email: " . $row["email"] . "</p>";
                } else {
                    echo "Nessun risultato trovato.";
                }
                echo '<a href="modificainfo.php" class="modifica-button">Modifica</a>';
                ?>
            </div>
        </div>
    </section>
    <section>
	<script>
function eliminaAppuntamento(idAppuntamento) {
    if (confirm("Sei sicuro di voler cancellare questo appuntamento?")) {
        // Crea un oggetto XMLHttpRequest per eseguire una richiesta POST in background
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "elimina_appuntamento.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        // Definisci la funzione di gestione della risposta (puoi gestire la risposta qui se necessario)
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Puoi gestire la risposta qui se necessario
                alert(xhr.responseText);
            }
        };
        
        // Invia la richiesta POST
        xhr.send("idAppuntamento=" + idAppuntamento);
    }
	                location.reload();

}
</script>

        <h2>Appuntamenti futuri</h2>
<div class="profile-container">
    <?php
    include 'connessione.php';
    $userId = $idUtente; 

    // Esegui la query SQL per ottenere gli appuntamenti
$query = "SELECT idAppuntamentoK AS idAppuntamento, ora, data, barbiere, servizi
          FROM appuntamentikevin
          WHERE idUtenti = $userId AND STR_TO_DATE(data, '%d-%m-%Y') >= CURDATE()
          UNION
          SELECT idAppuntamentoD AS idAppuntamento, ora, data, barbiere, servizi
          FROM appuntamentidiego
          WHERE idUtenti =$userId AND STR_TO_DATE(data, '%d-%m-%Y') >= CURDATE()
          ORDER BY ora";

    $result = $conn->query($query);

if ($result !== false && $result->num_rows > 0) 
{
    while ($row = $result->fetch_assoc()) {
        $dataAppuntamento = $row["data"];
        $oraAppuntamento = $row["ora"];
        $barbiereAppuntamento = $row["barbiere"];
        $idAppuntamento = $row["idAppuntamento"];
        $servizio = $row["servizi"];

if (preg_match('/(\d{2}:\d{2}):\d{2}/', $oraAppuntamento, $matches)) {
    $oraAppuntamento = $matches[1];
} else {
    $oraAppuntamento = $oraAppuntamento; // In caso di errore nella regex, assegna una stringa vuota
}

        // Visualizza i dettagli dell'appuntamento
        echo '<div class="profile-appointment">';
        echo "<p>Ora: $oraAppuntamento</p>";
        echo "<div>Data: $dataAppuntamento</div>"; // La data è ora posizionata in un div separato
        echo "<p>Barbiere: $barbiereAppuntamento</p>";
        echo "<p>Servizio: $servizio</p>";
        echo '<button class="cancel-button" data-appuntamento-id="' . $idAppuntamento . '" onclick="eliminaAppuntamento(' . $idAppuntamento . ')">Annulla</button>';
        echo '</div>';
    }
    } else {
        echo '<p>Nessun appuntamento futuro trovato.</p>';
    }
	            $conn->close();
            ?>
</div>
        </div>
    </section>
</main>
</body>
</html>
