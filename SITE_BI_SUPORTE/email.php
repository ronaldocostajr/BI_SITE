<?php
$Nome		= $_POST["nome"];	// Pega o valor do campo Nome
$Email		= $_POST["email"];	// Pega o valor do campo Email
$Mensagem	= $_POST["mensagem"];	// Pega os valores do campo Mensagem

// Variável que junta os valores acima e monta o corpo do email

$Vai 		= "Nome: $Nome\n\nE-mail: $Email\n\nMensagem: $Mensagem\n";

if ($Nome == "") {
  echo	"<script>location.href='erroemail.html'</script>";
  exit();
}

if ($Email == "") {
  echo	"<script>location.href='erroemail.html'</script>";
  exit();
}

require_once("/home/bisuport/public_html/phpmailer/class.phpmailer.php");

define('GUSER', 'suporte@bisuporte.com.br');
define('GPWD', 'JJ727155');

function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
	global $error;
	$mail = new PHPMailer();
	$mail->IsSMTP();		// Ativar SMTP
	$mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
	$mail->SMTPAuth = true;		// Autenticação ativada
	//$mail->SMTPSecure = 'ssl';	// SSL REQUERIDO pelo GMail
	$mail->Host = 'mail.bisuporte.com.br';	// SMTP utilizado
	$mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
	$mail->Username = GUSER;
	$mail->Password = GPWD;
	$mail->SetFrom($de, $de_nome);
	$mail->Subject = $assunto;
	$mail->Body = $corpo;
	$mail->AddAddress($para);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Mensagem enviada!';
		return true;
	}
}

// Insira abaixo o email que irá receber a mensagem, o email que irá enviar (o mesmo da variável GUSER), 
// nome do email que envia a mensagem, o Assunto da mensagem e por último a variável com o corpo do email.

 if (smtpmailer('contato@bisuporte.com.br', 'contato@bisuporte.com.br', 'BI SUPORTE', 'CONTATO SITE', $Vai)) {

    Header("location:http://www.bisuporte.com.br/emailenviado.html"); 

}
if (!empty($error)) {
	echo	"<script>location.href='erroemail.html'</script>";
    //Header("location:http://www.bisuporte.com.br/erroemail.html");
	//echo $error;
}	
?>