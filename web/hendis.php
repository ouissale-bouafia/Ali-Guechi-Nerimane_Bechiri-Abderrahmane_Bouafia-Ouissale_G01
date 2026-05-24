<?php include("header.php"); ?>

<h2 class="page-title">
    Free XQuery Console (BaseX)
</h2>

<form method="post" class="form-box">
    <textarea name="query" placeholder="Write your XQuery here..."><?php echo isset($_POST['query']) ? htmlspecialchars($_POST['query']) : ''; ?></textarea>
    <button type="submit">
        Execute Query
    </button>
</form>

<?php

if ($_POST && !empty($_POST['query'])) {

    $query = $_POST['query'];

    echo "
    <div class='query-result'>
        <h3>Query Sent</h3>
        <pre>" . htmlspecialchars($query) . "</pre>
    </div>
    ";



    $user = "admin";
    $pass = "admin"; 
    $url = "http://localhost:8080/rest?query=" . urlencode($query);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$user:$pass");
    
    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);

    echo "<div class='query-result'>";
    echo "<h3>Result</h3>";

    if ($curlError) {
        
        echo "<p style='color:red'>❌ Error: Cannot connect to BaseX server</p>";
        echo "<p>Details: $curlError</p>";
        echo "<p>Make sure BaseX HTTP Server is running on port 8080</p>";
    } else {
        if ($httpCode == 200) {
            
            echo "<pre>" . htmlspecialchars($response) . "</pre>";
        } elseif ($httpCode == 401) {
            
            echo "<p style='color:red'>❌ Error 401: Unauthorized access</p>";
            echo "<p>the pass word is wrong</p>";
        } else {
            
            echo "<p style='color:red'>❌ Server Error (Code: $httpCode)</p>";
            echo "<pre>" . htmlspecialchars($response) . "</pre>";
        }
    }

    echo "</div>";
    curl_close($ch);
}

?>

<?php include("footer.php"); ?>