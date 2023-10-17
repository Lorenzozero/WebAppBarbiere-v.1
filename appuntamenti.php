<?php
session_start();
include 'connessione.php';
if (!isset($_SESSION['admin_token'])) {
    // Se il token non è presente nella sessione, reindirizza l'utente alla pagina di login
    header('Location: loginAdmin.php');
    exit;
}
else
{
// Recupera il token dalla sessione
$token = $_SESSION['admin_token'];
// Query per verificare il token nel database
$query = "SELECT idToken FROM tokens WHERE token = '$token' AND expiration > NOW()";
$result = $conn->query($query);

if ($result->num_rows === 1) 
{
    // Il token è valido, l'utente ha accesso
} else 
{
    // Il token non è valido, reindirizza l'utente alla pagina di login
    header('Location: loginAdmin.php');
    exit;
}
}
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appuntamenti</title>
    <style>
        /* Stile CSS come precedentemente fornito */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: black;
            background-color: #333;
        }

        header {
            background-color: #111;
            color: #fff;
            padding: 20px;
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

        h1 {
            font-size: 36px;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin right: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            padding: 10px 20px;
            border: 2px solid #fff;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        nav ul li a:hover {
            background-color: #fff;
            color: #111;
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

        /* Stile specifico per la pagina degli appuntamenti */
        .appointment-list-container {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            max-width: 100%;
            margin: 0 auto;
            text-align: center;
            overflow: hidden;
        }

        /* Stile per le singole appuntamenti */
        .appointment-table {
            width: 100%;
            border-collapse: collapse;
            max-width: 100%;
            overflow-x: auto;
        }

        .appointment-table th, .appointment-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .appointment-table th {
            background-color: #f2f2f2;
        }

        .appointment-column {
            width: 50%;
            float: left;
            display: inline-block;
            box-sizing: border-box;
        }

        .table-heading {
            text-align: center;
            background-color: #000;
            color: #fff;
            padding: 5px;
        }

        /* Aggiungi la colonna vuota e nera per "Kevin" */
        .kevin-appointment-list-container {
            background-color: rgba(255, 255, 255, 0.4);
            border-radius: 5px;
            max-width: 100%;
            margin: 0 auto;
            text-align: center;
            overflow: hidden;
        }

        .empty-column {
            background-color: #000;
        }

        .appointment-table td:nth-child(1) {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="ControlPannel.html">ControlPannel</a></li>
                <li><a href="adminaggiungi.php">ADDappuntamento</a></li>
                <li><a href="registrazione.php">Registrazione</a></li>
            </ul>
        </nav>
        <h1>Appuntamenti</h1>
    </header>
    <main>
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
            }
        </script>
        <?php
        include 'connessione.php';

        $sqlKevin = "SELECT idAppuntamentoK,nome, cognome, nTelefono, email, data, ora, servizi 
            FROM appuntamentikevin 
            JOIN utenti  ON appuntamentikevin.idUtenti = utenti.idUtente
            WHERE barbiere = 'kevin' 
            ORDER BY data, ora";
        $resultKevin = $conn->query($sqlKevin);
        if (!$resultKevin) {
            die("Errore nella query SQL: " . $conn->error);
        }

        $sqlDiego = "SELECT idAppuntamentoD,nome,cognome,nTelefono,email,data,ora,servizi 
            FROM appuntamentidiego 
            JOIN utenti  ON appuntamentidiego.idUtenti = utenti.idUtente
            WHERE barbiere = 'diego' 
            ORDER BY data, ora";
        $resultDiego = $conn->query($sqlDiego);
        if (!$resultDiego) {
            die("Errore nella query SQL: " . $conn->error);
        }

        $kevinAppointments = [];
        $diegoAppointments = [];

        while ($row = $resultKevin->fetch_assoc()) {
            $kevinAppointments[$row["data"]][] = $row;
        }

        while ($row = $resultDiego->fetch_assoc()) {
            $diegoAppointments[$row["data"]][] = $row;
        }

        $dates = array_unique(array_merge(array_keys($kevinAppointments), array_keys($diegoAppointments)));
        sort($dates);

        foreach ($dates as $date) {
            echo "<section>";
            echo "<h2>Data: $date</h2>";
            echo "<div class='kevin-appointment-list-container'>";
            echo "<div class='appointment-column'>";
            echo "<div class='table-heading'>Kevin</div>"; 
            echo "<table class='appointment-table'>";
            echo "<tr><th>Ora</th><th>Nome</th><th>Cognome</th><th>Servizio</th><th>Telefono</th><th>Azioni</th><th style='background-color: #000;'></th>";

            if (isset($kevinAppointments[$date])) {
                foreach ($kevinAppointments[$date] as $kevinAppointment) {
                    $idAppuntamento = $kevinAppointment["idAppuntamentoK"];
                    echo "<tr>";
                    echo "<td>" . $kevinAppointment["ora"] . "</td>";
                    echo "<td>" . $kevinAppointment["nome"] . "</td>";
                    echo "<td>" . $kevinAppointment["cognome"] . "</td>";
                    echo "<td>" . $kevinAppointment["servizi"] . "</td>";
                    echo "<td>" . $kevinAppointment["nTelefono"] . "</td>";
                    echo "<td><button class='cancel-button' data-appuntamento-id='$idAppuntamento' onclick='eliminaAppuntamento($idAppuntamento)'>Annulla</button></td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
            echo "</div>";

            echo "<div class='divider-column'></div>";

            echo "<div class='appointment-column'>";
            echo "<div class='table-heading'>Diego</div>";
            echo "<table class='appointment-table'>";
            echo "<tr><th>Ora</th><th>Nome</th><th>Cognome</th><th>Servizio</th><th>Telefono</th><th>Azioni</th>";

            if (isset($diegoAppointments[$date])) {
                foreach ($diegoAppointments[$date] as $diegoAppointment) {
                    $idAppuntamento = $diegoAppointment["idAppuntamentoD"];
                    echo "<tr>";
                    echo "<td>" . $diegoAppointment["ora"] . "</td>";
                    echo "<td>" . $diegoAppointment["nome"] . "</td>";
                    echo "<td>" . $diegoAppointment["cognome"] . "</td>";
                    echo "<td>" . $diegoAppointment["servizi"] . "</td>";
                    echo "<td>" . $diegoAppointment["nTelefono"] . "</td>";
                    echo "<td><button class='cancel-button' data-appuntamento-id='$idAppuntamento' onclick='eliminaAppuntamento($idAppuntamento)'>Annulla</button></td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
            echo "</div>";

            echo "</div>";
            echo "</section>";
        }
        ?>
    </main>
</body>
</html>
