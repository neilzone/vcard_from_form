<?php

#change these settings before you upload this script:

#put the email address which you want the email to look as if it comes from between the quotation marks. If you are not sure, put your own email address:

$email_comes_from_this_address = "website_vcard_sender@example.com";

#put the email address you want the cards sent to between the quotation marks:
$send_to_this_address = "vcards_from_website@example.com";

#put your name between the quotation marks:
$your_name = "Test Name";


$firstname = filter_var($_POST["firstname"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

$surname = filter_var($_POST["surname"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);


$workphonenumber = filter_var($_POST["workphonenumber"], FILTER_SANITIZE_NUMBER_INT);

$homephonenumber = filter_var($_POST["homephonenumber"], FILTER_SANITIZE_NUMBER_INT);


$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $email = "";
}





$fullname = $firstname." ".$surname;

$cardname = $fullname.".vcf";


$content = "BEGIN:VCARD\r\n";
$content .= "VERSION:4.0\r\n";
$content .= "CLASS:PUBLIC\r\n";
$content .= "FN:".$fullname."\r\n";
$content .= "N:".$surname." ".$firstname.";;;\r\n";
$content .= "EMAIL;TYPE=internet,pref:".$email."\r\n";
$content .= "TEL;TYPE=work,voice:".$workphonenumber."\r\n";
$content .= "TEL;TYPE=HOME,voice:".$homephonenumber."\r\n";
$content .= "END:VCARD\r\n";

mail_attachment($cardname, $content, $send_to_this_address, $email_comes_from_this_address, $your_name, $email_comes_from_this_address, "vCard from ".$fullname, "");

function mail_attachment($filename, $content, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
    $fileatt_type = "text/x-vcard";

    $headers = "FROM: ".$from_mail;

    $data = $content;

    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    $headers .= "\nMIME-Version: 1.0\n" .
    "Content-Type: multipart/mixed;\n" .
    " boundary=\"{$mime_boundary}\"";

    $message = "This is a multi-part message in MIME format.\n\n" .
    "--{$mime_boundary}\n" .
    "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
    "Content-Transfer-Encoding: 7bit\n\n" .
    $message . "\n\n";
    $message .= "--{$mime_boundary}\n" .
    "Content-Type: {$fileatt_type};\n" .
    " name=\"{$filename}\"\n" .
    "Content-Transfer-Encoding: 8bit\n" .
    "Content-Disposition: attachment;\n" .
    " filename=\"{$filename}\"\n\n" .
    $data . "\n\n" .
    "--{$mime_boundary}--\n";
    //echo "sending message";
    mail($mailto, $subject, $message, $headers);
}
?>



<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Law firm vCard generator</title>

<body>

Thanks! Your details have been sent to <?php echo $your_name; ?>.

</body>
</html>