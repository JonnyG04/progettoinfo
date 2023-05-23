<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "my_proinfo";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if (creaUtente($conn, $username, $password)) {
            header("Location: login.php");
            exit();
        } else {
            $errore = "Errore durante la registrazione. Riprova.";
        }
    }

    function creaUtente($conn, $username, $password) {
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);

        $query = "INSERT INTO Utente (UsernameUtente, PasswordUtente) VALUES ('$username', '$password')";
        if ($conn->query($query) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
        <title>Login</title>
        <style>
            .body {
                font-family: Arial, sans-serif;
                background-color: #f8f9fa;
            }
            .card {
                max-width: 400px;
                margin: 0 auto;
                margin-top: 150px;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }
            .card-header {
                background-color: #f8f9fa;
                border-bottom: 1px solid #dee2e6;
            }
            .nav-tabs .nav-item {
                margin-bottom: 0;
            }
            .nav-link {
                color: #000;
                font-weight: bold;
            }
            .nav-link.active {
                background-color: #fff;
                border-color: #dee2e6 #dee2e6 #fff;
            }
            .card-body {
                padding: 20px;
            }
            .form-label {
                font-weight: bold;
            }
            .form-control {
                margin-bottom: 15px;
                border-radius: 5px;
                padding: 10px;
            }
            .btn-primary {
                background-color: #007bff;
                border-color: #007bff;
                font-weight: bold;
                padding: 10px 20px;
            }
            .btn-primary:hover {
                background-color: #0069d9;
                border-color: #0062cc;
            }
            .error-message {
                color: #dc3545;
                font-size: 14px;
                margin-top: 5px;
            }
        </style>
    </head>
    <body>
        <div class="card mx-auto my-5" style="width: 30rem;">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="btn_registrati">Registrati</a>
                    </li>
                </ul>
            </div>
            <div id="register" class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="mb-3">
                        <label for="username_reg" class="form-label">Username</label>
                        <input type="text" name="username" id="username_reg" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_reg" class="form-label">Password</label>
                        <input type="password" name="password" id="password_reg" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Registrati" name="register" class="btn btn-primary">
                    </div>
                    <?php if (isset($errore)): ?>
                        <div class="error-message"><?php echo $errore; ?></div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        <script>
            // Funzione JavaScript per mostrare/nascondere il form di registrazione
            var btnRegistrati = document.getElementById('btn_registrati');
            var registerForm = document.getElementById('register');

            btnRegistrati.addEventListener('click', function() {
                registerForm.style.display = 'block';
            });
        </script>
    </body>
</html>