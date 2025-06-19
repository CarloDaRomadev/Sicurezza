<?php
$servername = "db"; // Il nome del servizio Docker per il database
$username = "xss_user";
$password = "xss_password";
$dbname = "xss_db";

// Crea connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controlla connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Inizializza il database se non esiste la tabella
$sql = "CREATE TABLE IF NOT EXISTS comments (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    comment TEXT NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    // echo "Tabella comments creata con successo o già esistente";
} else {
    echo "Errore nella creazione della tabella: " . $conn->error;
}

// Gestione dell'invio del commento
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = $_POST["comment"];

    // * PUNTO DI VULNERABILITÀ XSS *
    // Nessuna sanificazione dell'input! Questo è il difetto che sfrutteremo.
    // In un'applicazione reale, useresti htmlspecialchars() o simili:
    // $comment = htmlspecialchars($_POST["comment"], ENT_QUOTES, 'UTF-8');

    $stmt = $conn->prepare("INSERT INTO comments (comment) VALUES (?)");
    $stmt->bind_param("s", $comment);

    if ($stmt->execute()) {
        // echo "Nuovo commento aggiunto con successo";
    } else {
        echo "Errore: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Assistenza Clienti - SecureBank S.p.A.</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
        }
        .header {
            background-color: #004080; /* Blu scuro, colore tipico banca */
            color: white;
            padding: 15px 30px;
            text-align: center;
            font-size: 2em;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #004080;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
            margin-top: 20px;
        }
        .forum-post {
            border: 1px solid #dcdcdc;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #fefefe;
            border-radius: 6px;
        }
        .forum-post strong {
            color: #0056b3;
        }
        textarea {
            width: calc(100% - 22px); /* Per tenere conto del padding e border */
            height: 100px;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Include padding e border nella larghezza */
        }
        input[type="submit"] {
            padding: 12px 25px;
            background-color: #007bff; /* Blu più vivace per i bottoni */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .disclaimer {
            font-size: 0.85em;
            color: #777;
            margin-top: 20px;
            text-align: center;
            padding-top: 15px;
            border-top: 1px dashed #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="header">
        SecureBank S.p.A. - Forum Assistenza Clienti
    </div>

    <div class="container">
        <h1>Benvenuto nel Forum di Assistenza Clienti SecureBank</h1>
        <p>Qui puoi porre domande, segnalare problemi o condividere le tue esperienze con i nostri servizi bancari. Il nostro team e la comunità ti risponderanno presto.</p>
        <p><strong>Avviso:</strong> Per la tua sicurezza, non condividere mai informazioni personali o credenziali bancarie in questo forum pubblico.</p>

        <form method="post" action="">
            <h2>Pubblica una Nuova Richiesta / Commento:</h2>
            <textarea name="comment" placeholder="Scrivi qui la tua richiesta o il tuo feedback..."></textarea><br>
            <input type="submit" value="Invia Richiesta">
        </form>

        <h2>Richieste e Commenti Recenti:</h2>
        <?php
        $sql = "SELECT id, comment, reg_date FROM comments ORDER BY reg_date DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='forum-post'>";
                echo "<strong>ID Richiesta:</strong> " . $row["id"] . "<br>";
                // * PUNTO DI VULNERABILITÀ XSS *
                // Qui il commento viene stampato direttamente senza sanificazione.
                echo "<strong>Contenuto:</strong> " . $row["comment"] . "<br>";
                echo "<strong>Data Pubblicazione:</strong> " . $row["reg_date"] . "<br>";
                echo "</div>";
            }
        } else {
            echo "<p>Nessuna richiesta o commento ancora.</p>";
        }
        $conn->close();
        ?>

        <div class="disclaimer">
            &copy; 2025 SecureBank S.p.A. Tutti i diritti riservati.
        </div>
    </div>
</body>
</html>