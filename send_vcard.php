<?php
$content = "BEGIN:VCARD\r\n";
$content .= "VERSION:3.0\r\n";
$content .= "CLASS:PUBLIC\r\n";
$content .= "FN:Joe Wegner\r\n";
$content .= "N:Wegner;Joe ;;;\r\n";
$content .= "TITLE:Technology And Systems Administrator\r\n";
$content .= "ORG:Wegner Design\r\n";
$content .= "ADR;TYPE=work:;;21 W. 20th St.;Broadview ;IL;60559;\r\n";
$content .= "EMAIL;TYPE=internet,pref:joe@wegnerdesign.com\r\n";
$content .= "TEL;TYPE=work,voice:7089181512\r\n";
$content .= "TEL;TYPE=HOME,voice:8352355189\r\n";
$content .= "URL:http://www.wegnerdesign.com\r\n";
$content .= "END:VCARD\r\n";

mail_attachment("Joe Wegner.vcf", $content, "test@neilzone.co.uk", "test@neilzone.co.uk", "vCard sender", "test@neilzone.co.uk", "A new vCard", "");

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