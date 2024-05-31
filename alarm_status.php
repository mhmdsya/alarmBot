<?php

// Variable connection select
$servername = "10.32.100.21";
$username = "ne2rks";
$password = "HackIdea#5";
$dbname = "data_cacti_ont";

// Create connection select
$conn = new mysqli($servername, $username, $password, $dbname);

// Select data
$sql = "SELECT * FROM jakarta_utara WHERE STATUS = 'DOWN' OR STATUS = 'UNKNOWN' ";

$result = $conn->query($sql);
$message = "";

if ($result->num_rows > 0) {

    // Output data alarmbot
    while($row = $result->fetch_assoc()) 
    {
        $bot_token = "5838761928:AAHRcMv2h_rJPNYnw1XwO6GtVbx9skTfnOM";
        $description = $row['description'];
        $ip_olt = $row['ip_olt'];
        $status = $row['status'];
        $sn_ont = $row['sn_ont'];
        $slot = $row['slot'];
        $port = $row['port'];
        $onu_id = $row['onu_id'];
    
        //Kirim Bot Telegram
        $message .= 
        'Site ID: ' .  $description ."\n". 
        'IP OLT: ' .  $ip_olt ."\n". 
        'SN ONT: ' .  $sn_ont ."\n".
        'Port: ' . $slot . "/" . $port . "/" . $onu_id ."\n".
        'Status: ' .  $status . "\n\n" ;
    }
}
      
$data = [
    'chat_id' => '661484639',
    'text' => '⚠️ALERT SITE DOWN⚠️'. "\n\n". $message,
];      
if($message != "" ){
    $response = file_get_contents("https://api.telegram.org/bot$bot_token/sendMessage?" . http_build_query($data));
}     
      
$conn->close();

?>
