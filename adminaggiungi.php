<?php
session_start();
include 'connessione.php';

if (!isset($_SESSION['admin_token'])) {
    // Se il token non è presente nella sessione, reindirizza l'utente alla pagina di login
    header('Location: loginAdmin.php');
    exit;
}

// Recupera il token dalla sessione
$token = $_SESSION['admin_token'];

// Query per verificare il token nel database
$query = "SELECT idToken FROM tokens WHERE token = '$token' AND expiration > NOW()";
$result = $conn->query($query);

if ($result->num_rows === 1) {
    // Il token è valido, l'utente ha accesso

    // Query per selezionare tutti gli utenti dalla tabella "utenti"
    $query = "SELECT idUtente, nome, cognome FROM utenti";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Inizializza l'array utenti
        $utenti = array();

        // Estrai i dati dalla query e aggiungili all'array utenti
        while ($row = mysqli_fetch_assoc($result)) {
            $utenti[] = $row;
        }

        // Chiudi la connessione al database
        mysqli_close($conn);
    } else {
        // Gestione dell'errore
        echo "Errore ";
    }
} else {
    // Il token non è valido, reindirizza l'utente alla pagina di login
    header('Location: loginAdmin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: white;
            background-color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        header {
            background-color: #111;
            color: #fff;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 80px;
        }

        h1 {
            font-size: 36px;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            width: 100%;
            display: flex;
        }

        /* Stili per la versione mobile */
        @media screen and (max-width: 768px) {
            nav ul li {
                margin-right: 10px;
            }

            nav ul li a {
                padding: 10px 15px;
            }
        }

        nav ul li {
            margin-right: 20px;
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

        .custom-button {
            background-color: black;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Modifica lo stile del modulo di prenotazione */
        .booking-form {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
            text-align: center;
        }

        .booking-form label,
        .booking-form select {
            display: block;
            margin-bottom: 10px;
        }

        .booking-form input[type="text"],
        .booking-form input[type="email"],
        .booking-form input[type="tel"],
        .booking-form input[type="date"],
        .booking-form input[type="time"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .booking-form select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .services-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .service {
            margin: 10px;
            text-align: center;
        }

        .service label {
            display: block;
        }

        /* Stile dei radio button per la selezione dei servizi */
        .service input[type="radio"] {
            display: none;
        }

        .service input[type="radio"] + label {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .service input[type="radio"]:checked + label {
            background-color: #fff;
            color: #000;
        }

        /* Stile dei checkbox per la selezione dei servizi */
        .service input[type="checkbox"] {
            display: none;
        }

        .service input[type="checkbox"] + label {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .service input[type="checkbox"]:checked + label {
            background-color: #fff;
            color: #000;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="registrazione.php">Registrazione</a></li>
                <li><a href="appuntamenti.php">Appuntamenti</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h2>segna la prenotazione da admin</h2>
            <div class="booking-container">
                <div class="booking-form">
                    <form action="gestisciappuntamentiadmin.php" method="post">
<label for="User">Cliente:</label>
<select id="User" name="User" required oninput="filterOptions()" placeholder="Inserisci il nome o il cognome del cliente">
    <?php
    foreach ($utenti as $utente) {
        $User = $utente["idUtente"];
        $nome = $utente["nome"];
        $cognome = $utente["cognome"];
        echo "<option value='$User'>$nome $cognome</option>";
    }
    ?>
</select>




                        <p>Barbiere:</p>
                        <div class="services-container">
                            <div class="service">
                                <input type="radio" id="diego" name="barbiere" value="diego" >
                                <label for="diego">Diego</label>
                            </div>
                            <div class="service">
                                <input type="radio" id="kevin" name="barbiere" value="kevin">
                                <label for="kevin">Kevin</label>
                            </div>
                        </div>
                        <p>Servizi:</p>
                        <div class="services-container">
                            <div class="service">
                                <input type="checkbox" id="haircut" name="services[]" value="haircut">
                                <label for="haircut">Haircut</label>
                            </div>
                            <div class="service">
                                <input type="checkbox" id="beardcut" name="services[]" value="beardcut">
                                <label for="beardcut">Beardcut</label>
                            </div>
                            <div class="service">
                                <input type="checkbox" id="color" name="services[]" value="color">
                                <label for="color">Color</label>
                            </div>
                            <div class="service">
                                <input type="checkbox" id="hairtatoo" name="services[]" value="hairtatoo" >
                                <label for="hairtatoo">HairTattoo</label>
                            </div>
                        </div>
                        <label for="date">Data:</label>
                        <input type="date" id="datepicker" name="date" class="flatpickr-input" required placeholder="Seleziona prima il barbiere">
                        <br>
                        <label for="time">Ora:</label>
                        <select id="time" name="time" required disabled>
                            <option value="">Seleziona una data valida prima</option>
                        </select>
                        <button class="custom-button" id="prenotaButton" type="submit">Prenota</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
<script>
    var xhr; // Definisci la variabile xhr qui

    // Aggiungi un event listener all'input barbiere
    var inputBarbiere = document.querySelectorAll('input[name="barbiere"]');
    inputBarbiere.forEach(function(input) {
        input.addEventListener('change', function() {
            var barbiereValue = document.querySelector('input[name="barbiere"]:checked').value;
            gestisciBarbiere(barbiereValue);
        });
    });

    // Inizializza Flatpickr sull'input data
    var dateInput = document.querySelector('#datepicker');
    var datepicker = flatpickr(dateInput, {
        enable: [], // Vuoto all'inizio, verrà popolato dopo
        altInput: true,
        altFormat: "d F Y", // Imposta il formato desiderato "giorno mese anno"
        dateFormat: "d-m-Y",
        minDate: "today",
        maxDate: new Date().fp_incr(30),
    });

 // Aggiungi un event listener all'input data
dateInput.addEventListener('change', function() {
    var dataSelezionata = datepicker.selectedDates[0].toLocaleDateString().split('T')[0];
	var dataSelezionata = dataSelezionata.replace(/\//g, '-');

    var barbiereSelezionato = document.querySelector('input[name="barbiere"]:checked').value;
    gestisciOrariDisponibili(barbiereSelezionato, dataSelezionata);
});


    function gestisciBarbiere(barbiere) {
        xhr = new XMLHttpRequest();
        xhr.open("POST", "gestiscidatedisponibili.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var date_disponibili = JSON.parse(xhr.responseText);
				
				
                 // selezione lunedi e domeniche    
var date_escluse = [];

for (var i = 0; i < date_disponibili.length; i++) {
  var parts = date_disponibili[i].split("-");
  var day = parseInt(parts[0]);
  var month = parseInt(parts[1]) - 1; // I mesi iniziano da 0 (0 = gennaio)
  var year = parseInt(parts[2]);

  var data = new Date(year, month, day);

  // La funzione getDay() restituisce 0 per domenica e 1 per lunedì
  if (data.getDay() !== 0 && data.getDay() !== 1) {
    date_escluse.push(date_disponibili[i]);
  }
}
                // Aggiorna le date disponibili in Flatpickr
                datepicker.set('enable', date_escluse);
            }
        };

        var data = "barbiere=" + barbiere;
        xhr.send(data);
    }

    function gestisciOrariDisponibili(barbiere, dataSelezionata) {
        xhr = new XMLHttpRequest();
        xhr.open("POST", "gestiscioredisponibili.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var orari_disponibili = JSON.parse(xhr.responseText);

                var timeSelect = document.querySelector('#time');
                timeSelect.innerHTML = '';

                if (orari_disponibili.length > 0) {
                    timeSelect.disabled = false;
                    timeSelect.innerHTML = '<option value="">Seleziona un orario</option>'; // Opzione vuota predefinita

                    orari_disponibili.forEach(function(ora) {
                        var option = document.createElement('option');
                        option.value = ora;
                        option.textContent = ora;
                        timeSelect.appendChild(option);
                    });
                } else {
                    timeSelect.disabled = true;
                    timeSelect.innerHTML = '<option value="">Nessun orario disponibile</option>'; // Opzione vuota predefinita
                }
            }
        };

        var data = "barbiere=" +barbiere + "&dataSelezionata=" + dataSelezionata;
        xhr.send(data);
    }
</script>

</body>
</html>
