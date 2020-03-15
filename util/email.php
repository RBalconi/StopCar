<?php

require_once('../lib/PHPMailer-master/src/PHPMailer.php');
require_once('../lib/PHPMailer-master/src/SMTP.php');

$mail = new PHPMailer\PHPMailer\PHPMailer();

$tipo = $_GET['tipo'];
$cod = $_GET['cod'];
$email_dest = $_GET['email'];
$senha = $_GET['senha'];

$mail->IsSMTP(); 
$mail->CharSet = 'UTF-8';
$mail->Port = 587; 
$mail->SMTPSecure = "tls";
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true; 
$mail->Username = 'mail@gmail.com';
$mail->Password = ''; 

$mail->From = "mail@gmail.com";
$mail->FromName = "name"; 

$mail->AddAddress($email_dest, $email_dest);
$mail->IsHTML(true); 

$mail->Subject = ""; 
$mail->Body = "Segue o Link de acesso e a senha para efetuar a edição: <br>".
        "<b>Senha: </b>".$senha. 
        "<br><b>Link: </b> <a href='http://localhost:8080/www/empresa/editarComSenha.php?cod=".$cod."'> Clique aqui!</a><br><br>".
        "Ou copie e cole esse link na barra de endereço do seu navegador: <br>". 
        "http://localhost:8080/www/empresa/editarComSenha.php?cod=".$cod;


$enviado = $mail->Send();

$mail->ClearAllRecipients();
$mail->ClearAttachments();

if ($enviado) {
    echo "<div class='alert alert-success' role='alert'>
            <strong>E-mail enviado com sucesso!</strong>
        </div>";
} else {
    echo"<div class='alert alert-danger' role='alert'>
            <h4 class='alert-heading'>Não foi possível enviar o e-mail!</h4>
            <p><b>Informações do erro:</b> </p>". $mail->ErrorInfo.
        "</div>";
       
}
?>