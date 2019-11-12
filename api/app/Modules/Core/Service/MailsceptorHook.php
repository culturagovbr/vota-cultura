<?php


namespace App\Modules\Core\Service;


class MailsceptorHook extends \Mailsceptor\MailsceptorHook
{
    /**
     * Process hook and return bool whether or not the internal
     * Mailsceptor hooks may continue.
     *
     */
    public function process()
    {
        // public property containing the email message
        /** @var \Swift_Message $email */
        $email = $this->swiftMessage;
        $subject = '[HOMOLOGAÇÃO] - ' .  $email->getSubject();

        $email->setSubject($subject);
        return true;
    }
}