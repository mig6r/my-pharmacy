<?php
/**
 * Created by PhpStorm.
 * User: Seb
 * Date: 01/05/2019
 * Time: 11:14
 */

namespace App\Notification;


use App\Entity\Contact;
use Twig\Environment;

class ContactNotification
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }


    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message("Message en provenance de My Pharmacy"))
            ->setFrom('s.opros@digimig.fr')
            ->setTo('s.opros@digimig.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('emails/contact.html.twig', [
                'contact' => $contact
            ]), 'text/html');
        $this->mailer->send($message);
    }
}