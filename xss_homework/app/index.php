<?php
$servername = "db";
$username = "xss_user";
$password = "xss_password";
$dbname = "xss_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS comments (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    comment TEXT NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if (!$conn->query($sql)) {
    echo "Errore nella creazione della tabella: " . $conn->error;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = $_POST["comment"];
    $stmt = $conn->prepare("INSERT INTO comments (comment) VALUES (?)");
    $stmt->bind_param("s", $comment);
    if (!$stmt->execute()) {
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
    <title>Forum Assistenza Clienti - Tua banca S.p.A.</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f8;
            color: #2c2c2c;
        }

        .header {
            background-color: #5b3fa5;
            color: white;
            padding: 1.5rem;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .container {
            max-width: 1600px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        h1, h2 {
            color: #5b3fa5;
            margin-bottom: 1rem;
        }

        textarea {
            width: 100%;
            min-height: 120px;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            resize: vertical;
        }

        button {
            background-color: #5b3fa5;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        button:hover {
            background-color: #472f88;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .forum-posts {
            margin-top: 2rem;
        }

        .forum-post {
            padding: 1rem;
            border-bottom: 1px solid #e0e0e0;
            background-color: #fafafa;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .post-meta {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .post-content {
            font-size: 1rem;
            line-height: 1.5;
        }

        .disclaimer {
            text-align: center;
            padding: 2rem 1rem;
            color: #888;
            font-size: 0.85rem;
            background-color: #f0f0f0;
            margin-top: 3rem;
        }

        @media (max-width: 600px) {
            .container {
                margin: 1rem;
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="header">Forum Assistenza Clienti - Tua Banca S.p.A.</div>
    <div class="container">
        <h1>Assistenza Clienti Online</h1>
        <p>Hai bisogno di aiuto? Descrivi il tuo problema.</p>

        <form method="post" action="">
            <h2>Nuova richiesta</h2>
            <div class="form-group">
                <label for="comment">Commento</label>
                <textarea id="comment" name="comment" required></textarea>
            </div>
            <button type="submit">Invia</button>
        </form>

        <div class="forum-posts">
            <h2>Richieste recenti</h2>
            <?php
            $sql = "SELECT id, comment, reg_date FROM comments ORDER BY reg_date DESC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='forum-post'>";
                    echo "<div class='post-meta'>ID: #" . $row["id"] . " | " . $row["reg_date"] . "</div>";
                    echo "<div class='post-content'>" . $row["comment"] . "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>Nessuna richiesta presente.</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
    <div class="disclaimer">&copy; 2025 Tua Banca S.p.A.</div>
</body>
</html>
