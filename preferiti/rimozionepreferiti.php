<?php
    if (isset($_GET['imdbID'])) 
    {
        $imdbID = $_GET['imdbID'];
        $file = 'preferiti.txt';
        $favorites = file_get_contents($file);

        if (strpos($favorites, $imdbID) !== false)
        {
            $favorites = str_replace($imdbID . "\n", "", $favorites);
            file_put_contents($file, $favorites);
            $message = 'Film rimosso dai preferiti con successo!';
        } 
        else 
        {
            $message = 'Il film non è presente nei preferiti.';
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