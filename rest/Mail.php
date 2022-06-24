<?php
class Mail
{
    public static function send_new_registration_email($username, $manager_email)
    {
        // Create the Transport
        $transport = (new Swift_SmtpTransport('smtp.elasticemail.com', 2525))
            ->setUsername('faris.sahovic@stu.ibu.edu.ba')
            ->setPassword('905E1932F95FDB691BB4A34BDF5E6808C916');

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

            $message = (new Swift_Message('New registration'))
                ->setFrom([$manager_email => 'Faris Sahovic'])
                ->setTo([$manager_email => 'Faris Sahovic'])
                ->setBody('New user has registered to Panic with username: ' . $username . ' !!!', 'text/html');
       
        // Send the message
        $result = $mailer->send($message);
    }
}