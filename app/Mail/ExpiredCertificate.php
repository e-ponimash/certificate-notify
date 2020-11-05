<?php

namespace App\Mail;

use App\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExpiredCertificate extends Mailable
{
    use Queueable, SerializesModels;

    private $certificate;

    /**
     * Create a new message instance.
     *
     * @param Certificate $certificate
     */
    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = str_replace('<MID>', $this->certificate->merchant_id, env('NOTIFY_CERT_EMAIL_SUBJECT', 'PayKeeper'));

        return $this->to(env('NOTIFY_CERT_EMAIL_TO', 'rsb-cert-test@paykeeper.ru'))
                    //->from(env('NOTIFY_CERT_EMAIL_FROM'))
                    ->text('email.certificate_plain')
                    ->subject($subject)
                    ->with([
                        'certificate' => $this->certificate
                    ]);
    }
}
