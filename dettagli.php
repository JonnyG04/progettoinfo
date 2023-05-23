<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <title>Details</title>
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
            	min-width: 700px;
                display: block;
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }

            h1 {
                text-align: center;
                margin-top: 30px;
            }

            .results-container {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-top: 50px;
            }

            .details-container {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 75%;
            }

            .details {
                flex: 2;
                margin-left: 20px;
            }

            .details-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            .details-table th,
            .details-table td {
                padding: 10px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            .details-table th {
                background-color: #f2f2f2;
                text-align: left;
                font-weight: bold;
            }

            .poster {
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .poster img {
                max-width: 300px;
                margin-left: 20px;
            }  
        </style>
    </head>
    <body>
        <nav>
            <div class="container">
                <ul>
                    <li>
                        <a href="./progetto.php">Home</a>
                    </li>
                    <li>
                        <a href="./preferiti/visualizzapreferiti.php">View Favourites</a>
                    </li>
                    <li>
                        <a href="./logout.php">Logout</a>
                    </li>    
                </ul>
            </div>
        </nav>
        <h1>Details</h1>
        <?php
            if (isset($_GET['imdbID'])) 
            {
                $imdbID = $_GET['imdbID'];
                $apiKey = "7e3b52837emsh87a5259f057eb63p16e586jsne86f2e2635aa";
                $curl = curl_init();
                curl_setopt_array($curl, 
                [
                    CURLOPT_URL => "https://movie-database-alternative.p.rapidapi.com/?r=json&i=" . urldecode($imdbID),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => 
                    [
                        "X-RapidAPI-Host: movie-database-alternative.p.rapidapi.com",
                        "X-RapidAPI-Key: " . $apiKey
                    ],
                ]);
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                if ($err) 
                {
                    echo "Errore nella richiesta API: " . $err;
                } 
                else 
                {
                    $movieDetails = json_decode($response, true);

                    if ($movieDetails['Response'] == "True") 
                    {
                        $Title = $movieDetails['Title'];
                        $Poster = $movieDetails['Poster'];
                        $Plot = $movieDetails['Plot'];
                        $Genre = $movieDetails['Genre'];
                        $Actors = $movieDetails['Actors'];
                        $Runtime = $movieDetails['Runtime'];
                        $Language = $movieDetails['Language'];
                        $Director = $movieDetails['Director'];
                        $Country = $movieDetails['Country'];
                        $imdbRating = $movieDetails['imdbRating'];
                        echo '<div class="results-container">';
                        echo '<div class="details-container">';
                        echo '<div class="poster">';
                        echo '<img src="' . $Poster . '" alt="Movie Poster">';
                        echo '</div>';
                        echo '<div class="details">';
                        echo '<table class="details-table">';
                        echo '<tr>';
                        echo '<th>Title</th>';
                        echo '<td>' . $Title . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th>Plot</th>';
                        echo '<td>' . $Plot . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th>Genre</th>';
                        echo '<td>' . $Genre . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th>Cast</th>';
                        echo '<td>' . $Actors . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th>Runtime</th>';
                        echo '<td>' . $Runtime . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th>Language</th>';
                        echo '<td>' . $Language . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th>Director</th>';
                        echo '<td>' . $Director . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th>Country</th>';
                        echo '<td>' . $Country . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th>Rating</th>';
                        echo '<td>' . $imdbRating . '</td>';
                        echo '</tr>';
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    } 
                    else 
                    {
                        echo "<h1>Errore: Impossibile recuperare i dettagli del film.</h1>";
                    }
                }
            } 
            else
            {
                echo '<h1>Errore: ImdbId non fornito.</h1>';
            }
        ?>
        <script>
            function redirectToProgetto(searchTerm)
            {
                window.location.href = "./progetto.php?search-input=" + searchTerm;
            }
        </script>
    </body>
</html>