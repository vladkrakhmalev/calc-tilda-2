<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html; charset=utf-8');

$emailFrom = 'admin@крахмалев.рф';
$weight = $_POST['weight'];
$place1 = $_POST['place1'];
$place2 = $_POST['place2'];
$tel1 = $_POST['tel1'];
$tel2 = $_POST['tel2'];
$door = $_POST['door'];
$product = $_POST['product'];
$fragility = $_POST['fragility'];
$cost = $_POST['cost'];
$price = $_POST['price'];
$token = '';

$subject = 'vladimak2001@gmail.com';
$title = "Заявка с сайта";
$message = "";

$message = $message . 'Вес посылки до : ' . $weight . ' кг.' . "\r\n";
$message = $message . 'Адрес отправки: ' . $place1 . "\r\n";
$message = $message . 'Адрес доставки: ' . $place2 . "\r\n";
$message = $message . 'Телефон отправителя: ' . $tel1 . "\r\n";
$message = $message . 'Телефон получателя: ' . $tel2 . "\r\n";
if($product) {
  $message = $message . 'Что везем: ' . $product . "\r\n";
}
if($cost) {
  $message = $message . 'Ценность: ' . $cost . "\r\n";
}
if($fragility) {
  $message = $message . '- Хрупкое' . "\r\n";
}
if($door) {
  $message = $message . '- Нужна доставка до двери' . "\r\n";
}
$message = $message . $price . "\r\n";

$response = array(
	'chat_id' => '',
	'text' => 'Заявка с сайта: ' . "\r\n" . $message
);
		
$ch = curl_init('https://api.telegram.org/bot' . $token . '/sendMessage');  
curl_setopt($ch, CURLOPT_POST, 1);  
curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_exec($ch);
curl_close($ch);

if(mail($subject, $title, $message, "From: $emailFrom\r\nReply-To: $emailFrom\r\nReturn-Path: $emailFrom\r\nContent-Type: text/plain; charset=utf-8\r\nContent-Transfer-Encoding: 8bit")) {
  echo json_encode(array('success' => 1));
} else {
  echo json_encode(array('success' => 0));
}

?>