<?php
    if (isset($_GET['imdbID'])) 
    {
        $imdbID = $_GET['imdbID'];
        $file = 'preferiti.txt';
        $favorites = file_get_contents($file);
        
        if (strpos($favorites, $imdbID) !== false) {
            $message = 'Il film è già presente nei preferiti.';
        }
        else 
        {
            $favorites .= $imdbID . "\n";
            file_put_contents($file, $favorites);
            $message = 'Film aggiunto ai preferiti con successo!';
        }
    }
    else 
    {
        $message = 'ImdbID del film non fornito.';
    }
?>
<script>
    alert("<?php echo $message; ?>");
    location.reload();
    window.location.href = "../progetto.php";
</script>