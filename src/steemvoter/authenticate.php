<?php
  if (isset($_GET['code'])) {

    // Params for POST request
    $data = array(
        'code' => $_GET['code'],
        'client_secret' => SC_CLIENT_SECRET
    );

    $payload = json_encode($data);

    // Prepare new cURL resource
    $ch = curl_init('https://steemconnect.com/api/oauth2/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    // Set HTTP Header for POST request
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload))
    );

    // Submit the POST request
    $result = curl_exec($ch);

    // Close cURL session handle
    curl_close($ch);

    $json = json_decode($result);
    $date = date("Y/m/d H:G:s", time() + $json->expires_in);

    // Add tokens to the database
    global $wpdb;
    $wpdb->query("INSERT INTO `steem_authorization` (`id`, `access_token`, " .
    "`user_login`, `expires_in`, `refresh_token`) VALUES (NULL, " .
    "'" . $json->access_token . "', '" . $json->username ."', '" .
    $date . "', '" . $json->refresh_token ."') ON DUPLICATE KEY UPDATE " .
    "`user_login`='" . $json->username ."';");
  }

?>
