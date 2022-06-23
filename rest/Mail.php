<?php
class Mail
{
    public static function send_register_welcome_email()
    {
        // Create the Transport
        $transport = (new Swift_SmtpTransport('smtp.mailgun.org', 587))
            ->setUsername('postmaster@sandboxe56d72b211a34642a707416091e286b1.mailgun.org')
            ->setPassword('b5c1ff96015a270dbb0b63d07dc96b6a-100b5c8d-51b6bb02');

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        if ($number_of_books_left === 1) {
            // Create a message
            $message = (new Swift_Message('Remaining book remainder'))
                ->setFrom([$manager_email => 'Manager'])
                ->setTo([$manager_email => 'Manager'])
                ->setBody('Dear Manager, <br><br> There is only one book with the name <b>' . $book_name . '</b> left.', 'text/html');
        } elseif ($number_of_books_left === 0) {
            // Create a message
            $message = (new Swift_Message('Remaining book remainder'))
                ->setFrom([$manager_email => 'Manager'])
                ->setTo([$manager_email => 'Manager'])
                ->setBody('Dear Manager, <br><br> There are no books with the name <b>' . $book_name . '</b> left.', 'text/html');
        }

        // Send the message
        $result = $mailer->send($message);
    }
}