<?php
require_once '../../includes/init.php';
require_once '../../includes/checkLoggedIn.php';

use PragmaRX\Google2FA\Google2FA;

if(isset($_POST["userId"])){
    $userId = filter_var($_POST["userId"],FILTER_SANITIZE_NUMBER_INT);
} else {
    $userId = '';
}
if(isset($_POST["subject"])){
    $subject = filter_var($_POST["subject"],FILTER_SANITIZE_STRING);
} else {
    $subject = '';
}
if(isset($_POST["bodyText"])){
    $bodyText = $_POST["bodyText"];
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    $bodyText = $purifier->purify($bodyText);
} else {
    $bodyText = '';
}
if(isset($_POST["sendLogin"])){
    $sendLogin = filter_var($_POST["sendLogin"],FILTER_SANITIZE_NUMBER_INT);
} else {
    $sendLogin = 0;
}
if(is_numeric($userId)){
    //First get details of current user
    $curUser = User::find_by_id($user->id);
    //Now get details of who we are sending to
    $toUser = User::find_by_id($userId);
    //Set up mail transport
    $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
        ->setUsername('mark.a.strange@gmail.com')
        ->setPassword('Trust1964');
    //$transport = Swift_MailTransport::newInstance();
    $message = Swift_Message::newInstance();
    $message->setSubject($subject);
    //$message->setFrom($curUser->email);
    $message->setFrom('admin@cotswoldcanals.com');
    $message->setTo(array($toUser->email => ($toUser->firstname . ' ' . $toUser->surname)));
    $message->setBody($bodyText,'text/html');
    if($sendLogin == 1){
        $google2fa = new Google2FA();
        $google2fa_url = $google2fa->getQRCodeGoogleUrl(
            'Cotswold Canals',
            $toUser->email,
            $toUser->googlesecretkey
        );
        $mpdf=new mPDF('','A4',9,'dejavusans');
        $mpdf->SetHTMLHeader('<h1>Cotswold Canals Trust<br/>Membership Database</h1><img src="/images//Cotswold-Canals-Trust-Logo220.jpg" width="110px" height="110px" style="margin-top:-90px; margin-right:-40px;float:right"/>');
        $html = '<br/>';
        $html .= '<h3 style="margin-top:20px">Account Login Details</h3>';
        $html .= '<p>Hello ' . $toUser->firstname . ' ' . $toUser->surname . '</p>';
        $html .= '<p>The following details should help you login to Cotswold Canals Membership Database:-</p>';
        $html .= '<table autosize="1" border="1" cellspacing="0">';
        $html .= '<tr><th>Google 2FA Secret</th><td>' . $toUser->googlesecretkey . '</td></tr>';
        $html .= '<tr><th>QR Code</th><td><img src="' . $google2fa_url . '"/></td></tr>';
        $html .= '</table>';
        $html .= '<p>We will send you your password separately. If you have problem logging in please let us know.</p>';
        $mpdf->WriteHTML($html);

        $content = $mpdf->Output('', 'S');
        $attachment = new Swift_Attachment($content, 'userAccountDetails.pdf', 'application/pdf');
        $message->attach($attachment);
    }

    $mailer = Swift_Mailer::newInstance($transport);
    $result = $mailer->send($message);
}