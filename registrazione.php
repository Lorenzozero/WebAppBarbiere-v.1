<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <style>
        /* Stile generale */
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

        /* Stile specifico per la pagina di registrazione */
        .registration-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .registration-form {
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

        .register-button {
            background-color: #333;
            color: white !important;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
			text-decoration: none !important;
        }

        @media (max-width: 768px) {
            .registration-form {
                max-width: 100%;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>"Registrazione"</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
				<li><a href="profilo.php">Profilo</a></li>
                <li><a href="https://wa.me/+39 349 867 7859?text=Buongiorno,%20vorrei%20chiarire%20alcune%20informazioni">Contatta</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Crea un nuovo account</h2>
            <div class="registration-container">
                <div class="registration-form">
				<form method="POST" action="nuovoaccaunt.php">
                    <input type="text" class="input-field" name="Nome" placeholder="Nome" required>
                    <input type="text" class="input-field" name="Cognome" placeholder="Cognome" required>
                    <input type="email" class="input-field" name="Email" placeholder="Email" required>
                    <input type="text" class="input-field" name="nTelefono" placeholder="Numero telefono" required>
                    <input type="password" class="input-field" name="Password" placeholder="Password" required>
                    <button type="submit" class="register-button">Registrati</button>
				</form>

                </div>
            </div>
        </section>
    </main>
</body>
</html>
