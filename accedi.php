<?php
session_start(); // Inizia la sessione (assicurati di includere questa linea all'inizio dello script)

include 'connessione.php'; // Includi il file di connessione al database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se il modulo è stato inviato tramite POST

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    // Esegui una query per cercare l'utente con l'email specificata
    $query = "SELECT idUtente, email, password FROM utenti WHERE email = '$email' LIMIT 1";
    $stmt = $conn->query($query);
    if ($stmt->num_rows == 1) 
	{
        // Trovato un utente con l'email specificata, verifica la password
        $row = $stmt->fetch_assoc();
        if (password_verify($password, $row['password'])) 
		{
			echo "<script>alert('Accesso riuscito');</script>";
            // La password è corretta, imposta la variabile di sessione per l'ID dell'utente
            $_SESSION['logged_in'] = true;
            $_SESSION['idUtente'] = $row['idUtente'];
            echo '<meta http-equiv="refresh" content="3;url=profilo.php">';
            exit;
        } else 
		{
			echo "<script>alert('password sbagliata, riprovare');</script>";
            echo '<meta http-equiv="refresh" content="3;url=login.php">';
            exit;
        }
    } else 
	{
        echo "<script>alert('utente non trovato, riprovare');</script>";
        header("Location: login.php");
        exit;
    }
}
?>
