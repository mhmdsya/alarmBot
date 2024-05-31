<?php

// Variable connection select
$servername = "10.32.100.21";
$username = "ne2rks";
$password = "HackIdea#5";
$dbname = "data_cacti_ont";

// Create connection select
$conn = new mysqli($servername, $username, $password, $dbname);

// Select data
$sql = "SELECT * FROM jakarta_utara 
        WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(redaman, '|', 2), '|', -1) IS NOT NULL
        OR CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(redaman, '|', 2), '|', -1) AS DECIMAL(10, 2)) < -24 
        OR CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(redaman, '|', 2), '|', -1) AS DECIMAL(10, 2)) > -7 ";

$result = $conn->query($sql);
$message = "";

if ($result->num_rows > 0) {

    // Output data alarmbot
    while($row = $result->fetch_assoc()) 
    {
        $bot_token = "5838761928:AAHRcMv2h_rJPNYnw1XwO6GtVbx9skTfnOM";
        $description = $row['description'];
        $ip_olt = $row['ip_olt'];
        $sn_ont = $row['sn_ont'];
        $slot = $row['slot'];
        $port = $row['port'];
        $onu_id = $row['onu_id'];
        
        $redaman = $row['redaman'];

        // Pisahkan string `redaman` berdasarkan simbol `|`
        $redamanParts = explode('|', $redaman);
        
        // Cek apakah ada nilai setelah simbol `|`
        $redamanAfterPipe = '';
        if (count($redamanParts) > 1) {
            // Ambil nilai setelah simbol `|`
            $redamanAfterPipe = $redamanParts[1];
        }
    
        //Kirim Bot Telegram
        $message .= 
        'Site ID: ' .  $description ."\n". 
        'IP OLT: ' .  $ip_olt ."\n". 
        'SN ONT: ' .  $sn_ont ."\n".
        'Port: ' . $slot . "/" . $port . ":" . $onu_id ."\n".
        'Redaman: ' .  $redamanAfterPipe . "\n\n" ;
    }
}
      
$data = [
    'chat_id' => '661484639',
    'text' => '⚠️Redaman terlalu kecil dan besar⚠️'. "\n\n". $message,
];      
if($message != "" ){
    $response = file_get_contents("https://api.telegram.org/bot$bot_token/sendMessage?" . http_build_query($data));
}     
      
$conn->close();

?>
