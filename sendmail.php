<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';


$mail = new PHPMailer(true);
$mail->CharSet ='UTF-8';
$mail->setLanguage('ru', 'phpmailer/language/');
$mail->IsHTML(true);

// От кого письмо
$mail->setForm('fedyatreyder@mail.ru', 'Nasridinov Foziljon');
// Кому отправить 
$mail->addAddress('zuhriddinbostonov@gmail.com');
//Тема письма
$mail->Subject = 'Привет! Это Я Фозилжон';

//Рука
$hand = "Правая";
if($_POST['hand'] == 'left'){
    $hand = "Левая";
}

//Тeло писма
$body = '<h1>Новое Писмо для вас!</h1>';

if(trim(!empty($_POST['name']))){
    $body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
}
if(trim(!empty($_POST['email']))){
    $body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
}
if(trim(!empty($_POST['hand']))){
    $body.='<p><strong>Рука:</strong> '.$hand.'</p>';
}
if(trim(!empty($_POST['age']))){
    $body.='<p><strong>Возраст:</strong> '.$_POST['age'].'</p>';
}
if(trim(!empty($_POST['message']))){
    $body.='<p><strong>Сообщение:</strong> '.$_POST['message'].'</p>';
}

//Прикрепит файл
if(!empty($_FILES['image']['tmp_name'])){
    //Путь загруски файла
    $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
    //Грузим файл
    if(copy($_FILES['image']['tmp_name'], $filePath)){
        $fileAttach = $filePath;
        $body.='<p><strong>Фото в приложении </strong>';
        $mail->addAttachment($fileAttach);
    }
}

$mail->Body = $body;

//Отправляем
if(!$mail->send()) {
    $message = 'Ошибка';
}else {
    $message = 'Данные отправлены';
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);

?>
