<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
// require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language/');
$mail->IsHTML(true);


//From whom the letter
$mail->setFrom('gajovich79@gmail.com', 'Mailer');

$mail->addAddress('gajovich79@gmail.com'); // Вказати потрібний E-mail
//Leaf theme
$mail->Subject = 'Hello! This is "Surething Remodeling"';

//The body of the letter
$body = "<h1>Meet Super Letter!</h1>";

if (trim(!empty($_POST['name']))) {
	$body .= '<p><strong>Name:</strong> ' . $_POST['name'] . '</p>';
}
if (trim(!empty($_POST['email']))) {
	$body .= '<p><strong>Email:</strong> ' . $_POST['email'] . '</p>';
}
if (trim(!empty($_POST['phone']))) {
	$body .= '<p><strong>Phone:</strong> ' . $_POST['phone'] . '</p>';
}
if (trim(!empty($_POST['address']))) {
	$body .= '<p><strong>Address:</strong> ' . $_POST['address'] . '</p>';
}
if (trim(!empty($_POST['message']))) {
	$body .= '<p><strong>Message:</strong> ' . $_POST['message'] . '</p>';
}

//Прикріпити файл
if (!empty($_FILES['image']['tmp_name'])) {
	//шлях завантаження файлу
	$filePath = __DIR__ . "/files/sendmail/attachments/" . $_FILES['image']['name'];
	//грузимо файл
	if (copy($_FILES['image']['tmp_name'], $filePath)) {
		$fileAttach = $filePath;
		$body .= '<p><strong>Фото у додатку</strong>';
		$mail->addAttachment($fileAttach);
	}
}


$mail->Body = $body;

//Відправляємо
if (!$mail->send()) {
	$message = 'Помилка';
} else {
	$message = 'Дані надіслані!';
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
