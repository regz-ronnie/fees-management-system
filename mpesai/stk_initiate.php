<?php
if (isset($_POST['submit'])) {
    date_default_timezone_set('Africa/Nairobi');

    // Database connection
    $servername = "localhost"; // Replace with your database server
    $username = "root";        // Replace with your database username
    $password = "";            // Replace with your database password
    $dbname = "paysystem";   // Replace with your database name

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Access token
    $consumerKey = 'nk16Y74eSbTaGQgc9WF8j6FigApqOMWr'; // Fill with your app Consumer Key
    $consumerSecret = '40fD1vRXCq90XFaU';              // Fill with your app Secret

    // M-PESA credentials
    $BusinessShortCode = '174379';
    $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';

    // Input details
    $PartyA = $_POST['phone']; // Phone number of the payer
    $AccountReference = 'Viselah Limited.';
    $TransactionDesc = 'Test Payment';
    $Amount = $_POST['amount'];

    // Timestamp and password
    $Timestamp = date('YmdHis');
    $Password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

    // Access token URL
    $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $CallBackURL = 'https://morning-basin-87523.herokuapp.com/callback_url.php';

    // Generate access token
    $headers = ['Content-Type:application/json; charset=utf8'];
    $curl = curl_init($access_token_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
    $result = curl_exec($curl);
    $result = json_decode($result);
    $access_token = $result->access_token;
    curl_close($curl);

    // STK push header
    $stkheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];

    // Initiate transaction
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $initiate_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader);

    $curl_post_data = array(
        'BusinessShortCode' => $BusinessShortCode,
        'Password' => $Password,
        'Timestamp' => $Timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $Amount,
        'PartyA' => $PartyA,
        'PartyB' => $BusinessShortCode,
        'PhoneNumber' => $PartyA,
        'CallBackURL' => $CallBackURL,
        'AccountReference' => $AccountReference,
        'TransactionDesc' => $TransactionDesc
    );

    $data_string = json_encode($curl_post_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $curl_response = curl_exec($curl);
    $response = json_decode($curl_response, true);

    // Determine payment status
    $status = 'Not Paid'; // Default status
    if (isset($response['ResponseCode']) && $response['ResponseCode'] == '0') {
        $status = 'Pending'; // Payment initiated successfully
    }

    // Log transaction in the database
    $sql = "INSERT INTO payments (phone, amount, status) VALUES ('$PartyA', '$Amount', '$status')";
    if ($conn->query($sql) === TRUE) {
        echo '<p>Payment successfully initiated.</p>';
        echo '<p>Check your phone and input PIN to complete the transaction.</p>';
    } else {
        echo '<p>Error: ' . $sql . '<br>' . $conn->error . '</p>';
    }

    // Check if payment was completed (update status if necessary)
    if ($status === 'Pending') {
        // Simulate a callback to update payment status
        // This part assumes you have set up a proper callback handler for real use
        $completed = true; // Replace with actual logic to verify payment completion
        if ($completed) {
            $update_sql = "UPDATE payments SET status='Paid' WHERE phone='$PartyA' AND status='Pending'";
            $conn->query($update_sql);
            echo '<p>Payment completed successfully.</p>';
        } else {
            echo '<p>Payment not yet completed.</p>';
        }
    }

    $conn->close();
}
?>
