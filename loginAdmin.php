<?php
session_start();
include 'connessione.php';

if (isset($_SESSION['admin_token'])) {
    // Se il token è presente nella sessione, reindirizza l'utente alla pagina di login
    header('Location: loginAdmin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Stile CSS simile alla pagina del profilo */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: white;
            background-color: #333;
        }

        header {
            background-color: #111;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h1 {
            font-size: 28px;
            margin-right: auto;
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

        /* Stile specifico per la pagina di login */
        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-form {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            padding: 20px;
            max-width: 400px;
            text-align: center;
            margin-bottom: 20px;
        }

        .input-field {
            margin: 10px 0;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .login-button {
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        /* Stile per il pulsante "Registrati" */
        .register-button {
            background-color: grey;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

 
        /* Stile per il pulsante di accesso con Google */
        .google-login-button {
            background-color: #fff;
            border: 2px solid blue;
            border-radius: 50%; /* Rendi il pulsante rotondo */
            width: 90px; /* Imposta la larghezza del pulsante */
            height: 70px; /* Imposta l'altezza del pulsante */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px; /* Imposta la dimensione del testo */
            cursor: pointer;
            margin-top: 10px; /* Aggiungi spazio tra il pulsante Accedi e il pulsante Google */
            color: black; /* Imposta il colore del testo a nero */
        }

        /* Stile per l'icona "G" */
        .google-login-button img {
            width: 50px; /* Imposta la dimensione dell'icona di Google */
            vertical-align: middle;
        }
    </style>
</head>
<body>

    <header>
        <h1>LoginAdmin</h1>
    </header>
    <main>
	
<section>
    <h2>Effettua il login per admin</h2>
    <div class="login-container">
        <form class="login-form" method="post" action="accediadmin.php">
            <input type="text" class="input-field" placeholder="utente" name="utente" required autocomplete="utente">
            <input type="password" class="input-field" placeholder="Password" name="password" required autocomplete="current-password">
            <button type="submit"class="login-button">Accedi</button>
        </form>
    </div>
</section>
    </main>
</body>
</html>
