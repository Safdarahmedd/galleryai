<?php
function fetch_images($search_term) {
    $apiUrl = 'https://example.com/api/search'; // Replace with your actual API URL
    $apiKey = 'YOUR_API_KEY_HERE'; // Replace with your actual API key

    // Initialize cURL session
    $curl = curl_init();

    // Set cURL options
    curl_setopt($curl, CURLOPT_URL, $apiUrl . '?q=' . urlencode($search_term));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Authorization: Bearer ' . $apiKey 
    ]);

    // Execute cURL session
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        // Handle error scenario
        echo "cURL Error #:" . $err;
        return [];
    } else {
        // Decode JSON response and return
        return json_decode($response, true);
    }
}

// Handling form submission
$search_results = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_term'])) {
    $search_term = $_POST['search_term'];
    $search_results = fetch_images($search_term);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>GalleryAI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="./assets/css/App.css">
    <script type="text/javascript" src="./assets/js/sdk/lib/axios/dist/axios.standalone.js"></script>
            <script type="text/javascript" src="./assets/js/sdk/lib/CryptoJS/rollups/hmac-sha256.js"></script>   <!--unsure about the crypto ones-->
            <script type="text/javascript" src="./assets/js/sdk/lib/CryptoJS/rollups/sha256.js"></script>
            <script type="text/javascript" src="./assets/js/sdk/lib/CryptoJS/components/hmac.js"></script>
            <script type="text/javascript" src="./assets/js/sdk/lib/CryptoJS/components/enc-base64.js"></script>
            <script type="text/javascript" src="./assets/js/sdk/lib/url-template/url-template.js"></script>
            <script type="text/javascript" src="./assets/js/sdk/lib/apiGatewayCore/sigV4Client.js"></script>
            <script type="text/javascript" src="./assets/js/sdk/lib/apiGatewayCore/apiGatewayClient.js"></script>
            <script type="text/javascript" src="./assets/js/sdk/lib/apiGatewayCore/simpleHttpClient.js"></script>
            <script type="text/javascript" src="./assets/js/sdk/lib/apiGatewayCore/utils.js"></script>
        
            <script type="text/javascript" src="./assets/js/sdk/apigClient.js"></script>
</head>
<body class="mainmain">
    <center>
        <div class="mainsection">
            <header class="page-header">
                <h1>Gallery AI</h1>
            </header>
            <div class="bar">
                <form method="post">
                    <input style="display:inline-block;" id="searchbar" class="searchbar" type="text" name="search_term" title="Search" placeholder="Search for an image with text">
                    <button type="submit">Search</button>
                </form>
            </div>
            <div class="image-grid">
                <?php foreach ($search_results as $image): ?>
                    <img src="<?= htmlspecialchars($image['url']) ?>" alt="Search Result">
                <?php endforeach; ?>
            </div>
        </div>
    </center>
</body>
</html>
