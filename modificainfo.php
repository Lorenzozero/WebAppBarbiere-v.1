<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Informazioni Utente</title>
    <style>
	   header {
            background-color: #111;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
       nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin-right: 10px;
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
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: white;
            background-color: #333; /* Cambia il colore di sfondo */
        }

        /* ... (Altro stile CSS fornito) ... */

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            padding: 20px;
        }

        form label {
            display: block;
            margin-bottom: 10px;
        }

        form input[type="text"],
        form input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.8);
            color: #333;
        }

        form input[type="submit"] {
            background-color: #fff;
            color: #111;
            border: 2px solid #fff;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #111;
            color: #fff;
        }
    </style>
</head>
<body>
    <header>
        <h1>Modifica Informazioni Utente</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="profilo.php">Profilo</a></li>
            </ul>
        </nav>
    </header>
    <main>
       <section>
            <div class="profile-container">
                <form method="post">
					<?php
session_start();

// Verifica se l'utente è loggato
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Utente non loggato, reindirizza alla pagina di login in modo sicuro
    header('Location: login.php');
    exit; // Assicura che lo script si interrompa dopo il reindirizzamento
}

$idUtente = (int)$_SESSION['idUtente']; // Cast a intero per sicurezza

include 'connessione.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars($_POST["nome"], ENT_QUOTES, 'UTF-8');
    $cognome = htmlspecialchars($_POST["cognome"], ENT_QUOTES, 'UTF-8');
    $nTelefono = htmlspecialchars($_POST["nTelefono"], ENT_QUOTES, 'UTF-8');
    $email = $_POST["email"];

    // Esegui l'aggiornamento delle informazioni dell'utente nel database utilizzando statement preparati
    $updateQuery = $conn->prepare("UPDATE utenti SET nome = ?, cognome = ?, nTelefono = ?, email = ? WHERE idUtente = ?");
    $updateQuery->bind_param("ssssi", $nome, $cognome, $nTelefono, $email, $idUtente);

    if ($updateQuery->execute()) {
        // Notifica di successo
        echo '<div id="success-notification">Informazioni aggiornate con successo!</div>';
		header('Location: profilo.php');

    } else {
        echo "Errore durante l'aggiornamento delle informazioni: " . $conn->error;
    }
}

// Ottieni e visualizza le informazioni attuali dell'utente
$sql = "SELECT nome, cognome, nTelefono, email FROM utenti WHERE idUtente = ?";
$getInfo = $conn->prepare($sql);
$getInfo->bind_param("i", $idUtente);
$getInfo->execute();
$getInfo->bind_result($nomeAttuale, $cognomeAttuale, $nTelefonoAttuale, $emailAttuale);

if ($getInfo->fetch()) {
    // Visualizza le informazioni attuali nell'HTML in modo sicuro
    echo '<label for="nome">Nome:</label>';
    echo "<input type='text' name='nome' id='nome' value='" . htmlspecialchars($nomeAttuale, ENT_QUOTES, 'UTF-8') . "' required><br>";
    echo '<label for="cognome">Cognome:</label>';
    echo "<input type='text' name='cognome' id='cognome' value='" . htmlspecialchars($cognomeAttuale, ENT_QUOTES, 'UTF-8') . "' required><br>";
    echo '<label for="nTelefono">Numero di Telefono:</label>';
    echo "<input type='text' name='nTelefono' id='nTelefono' value='" . htmlspecialchars($nTelefonoAttuale, ENT_QUOTES, 'UTF-8') . "' required><br>";
    echo '<label for="email">Email:</label>';
    echo "<input type='email' name='email' id='email' value='" . htmlspecialchars($emailAttuale, ENT_QUOTES, 'UTF-8') . "' required><br>";
    echo "<center><input type='submit' value='Salva Modifiche'>";
}
?>
                </form>
            </div>
        </section>
    </main>

    <script>
        // JavaScript rimane invariato
    </script>
</body>
</html>