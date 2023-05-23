<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <title>Movies</title>
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
            	min-width: 600px;
                display: block;
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }

            h1 {
                text-align: center;
                margin-top: 30px;
            }

            .input-group {
            display: flex;
            align-items: center;
            justify-content: center;
            }

            .search-container {
                text-align: center;
                margin-bottom: 20px;
            }

            .search-container input[type="text"] {
                padding: 8px;
                width: 300px;
                font-size: 16px;
                border-radius: 4px;
                border: 1px solid #ddd;
            }

            .search-container button {
                background-color: #4CAF50;
                color: white;
                padding: 8px 12px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 14px;
            }

            .search-container button:hover {
                background-color: #45a049;
            }

            .results-container {
                margin: 0 auto;
                max-width: 600px;
            }

            table {
                border: 1px solid #ddd;
                width: 100%;
                border-collapse: collapse;
            }

            table thead th {
                background-color: #f5f5f5;
                font-weight: bold;
                padding: 10px;
                text-align: center;
                border-bottom: 1px solid #ddd;
            }

            table tbody tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            table tbody tr:hover {
                background-color: #f1f1f1;
            }

            th, td {
                border: 1px solid #ddd;
                padding: 10px;
                text-align: center;
                border-bottom: 1px solid #ddd;
            }

            th {
                background-color: #f2f2f2;
                font-weight: bold;
            }

            table a:hover {
                text-decoration: underline;
            }

            .details-button,
            .add-button
            {
                display: block;
                margin: 0 auto;
                background-color: #4CAF50;
                color: white;
                padding: 8px 12px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 14px;
            }

            .details-button:hover,
            .add-button:hover,
            .remove-button:hover {
                background-color: #45a049;
            }

            .no-results {
                text-align: center;
                padding: 20px;
                font-style: italic;
                color: #888;
            }
        </style>
    </head>
    <body>     
        <nav>
            <div class="container">
                <ul>
                    <li>
                        <a href="./preferiti/visualizzapreferiti.php">View Favourites</a>
                    </li>
                    <li>
                        <a href="./logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container">  
            <h1>Search Movies</h1>
            <form id="search-form" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="input-group">
                    <input type="text" name="search-input" placeholder="Enter the movie/serie title">
                    <button type="submit">Search</button>
                </div>
            </form>
            <br>
            <br>
            <?php
                if (isset($_GET['search-input'])) 
                {     
                    $searchTerm = $_GET['search-input'];
                    $apiKey = "7e3b52837emsh87a5259f057eb63p16e586jsne86f2e2635aa";

                    $curl = curl_init();
                    curl_setopt_array($curl, [
                        CURLOPT_URL => "https://movie-database-alternative.p.rapidapi.com/?s=" . urlencode($searchTerm),
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

                    if ($err) 
                    {
                        echo "Errore nella richiesta API: " . $err;
                    } 
                    else 
                    {
                        $movies = json_decode($response, true);

                        if (isset($movies['Search']) && is_array($movies['Search'])) 
                        {
                            usort($movies['Search'], function ($a, $b)
                            {
                                return $b['Year'] <=> $a['Year'];
                            });
                            echo '<div id="results-container">';
                            echo '<div class="col-sm-12">';
                            echo '<table class="table text-center">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th scope="col">Title</th>';
                            echo '<th scope="col">Year</th>';
                            echo '<th scope="col">Type</th>';
                            echo '<th scope="col">imdbID</th>';
                            echo '<th scope="col">Details</th>';
                            echo '<th scope="col">Favorites</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            foreach ($movies['Search'] as $movie) 
                            {
                                $Title = $movie['Title'];
                                $Year = $movie['Year'];
                                $Type = $movie['Type'];
                                $imdbID = $movie['imdbID'];
                                echo '<tr>';
                                echo '<td>' . $Title . '</td>';
                                echo '<td>' . $Year . '</td>';
                                echo '<td>' . $Type . '</td>';
                                echo '<td>' . $imdbID . '</td>';
                                echo '<td style="text-align: center;"><button class="details-button" onclick="showDetails(\'' . $imdbID . '\')">Details</button></td>';
                                echo '<td style="text-align: center;"><button class="add-button" onclick="addToFavorites(\'' . $imdbID . '\')">Add</button></td>';
                                echo '</tr>';
                            }
                            echo '</tbody>';
                            echo '</table>';
                            echo '</div>';
                            echo '</div>';
                        } 
                        else 
                        {
                            echo '<div id="results-container">No movies found.</div>';
                        }
                    }
                }
            ?>
        </div>
        
        <script>
            function showDetails(imdbID)
            {
                window.location.href = "./dettagli.php?imdbID=" + imdbID;
            }
     
            function addToFavorites(imdbID) 
            {
                window.location.href = "./preferiti/aggiuntapreferiti.php?imdbID=" + imdbID;
                fetch('preferiti.php?imdbID=' + imdbID)
                    .then(response => {
                        if (response.ok)
                        {
                            console.log('Film aggiunto ai preferiti!');
                        } 
                        else
                        {
                            console.error('Errore durante l\'aggiunta del film ai preferiti.');
                        }
                    })
                .catch(error => {
                console.error('Errore durante la richiesta di aggiunta del film ai preferiti:', error);
                });
                
            }
        </script>
    </body>
</html>