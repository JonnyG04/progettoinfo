<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Favorites</title>
    <style>
        nav {
            background-color: #f5f5f5;
            padding: 10px;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: right;
        }

        nav li {
            display: inline-block;
            margin-right: 10px;
        }

        nav a {
            text-decoration: none;
            color: #333;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        nav a:hover {
            background-color: #333;
            color: #fff;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .card {
            width: 200px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card-poster {
            width: 100%;
            border-radius: 10px 10px 0 0;
        }

        .card-body {
            padding: 10px;
        }

        .card-title {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .remove-button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px; /* Aggiunto spazio tra titolo e pulsante */
        }

        .remove-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <nav>
        <div class="container">
            <ul>
                <li>
                    <a href="../progetto.php">Home</a>
                </li>
                <li>
                    <a href="../logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <h1>Favorites</h1>
    <br>
    <br>
    <?php
        $file = 'preferiti.txt';
        $favorites = file_get_contents($file);
        $favoriteMovies = explode("\n", $favorites);
        $favoriteMovies = array_filter($favoriteMovies);

        if (empty($favoriteMovies)) {
            echo 'Nessun film preferito trovato.';
        } else {
            echo '<div class="card-container">';

            foreach ($favoriteMovies as $imdbID) {
                $apiKey = "7e3b52837emsh87a5259f057eb63p16e586jsne86f2e2635aa";
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://movie-database-alternative.p.rapidapi.com/?r=json&i=" . urldecode($imdbID),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "X-RapidAPI-Host: movie-database-alternative.p.rapidapi.com",
                        "X-RapidAPI-Key: " . $apiKey
                    ],
                ]);
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                if ($err) {
                    echo "Errore nella richiesta API: " . $err;
                } else {
                    $movie = json_decode($response, true);

                    if (isset($movie['Title'])) {
                        echo '<div class="card">';
                        echo '<img src="' . $movie['Poster'] . '" alt="' . $movie['Title'] . '" class="card-poster">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $movie['Title'] . '</h5>';
                        echo '<button class="remove-button" onclick="removeToFavorites(\'' . $imdbID . '\')">Rimuovi Preferiti</button>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            }
            echo '</div>';
        }
    ?>
    <script>
        function removeToFavorites(imdbID) {
            window.location.href = "./rimozionepreferiti.php?imdbID=" + imdbID;
            fetch('preferiti.php?imdbID=' + imdbID)
                .then(response => {
                    if (response.ok) {
                        console.log('Film rimosso dai preferiti!');
                    } else {
                        console.error('Errore durante la rimozione del film dai preferiti.');
                    }
                })
                .catch(error => {
                    console.error('Errore durante la richiesta di rimozione del film dai preferiti:', error);
                });
        }
    </script>
</body>
</html>