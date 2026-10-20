<?php

namespace App\Mail;

use Illuminate\Support\Facades\Http;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\MessageConverter;

/**
 * Sends mail through Brevo's HTTPS API (https://api.brevo.com/v3/smtp/email).
 * Uses HTTPS (port 443), so it works on hosts that block SMTP, like Railway Hobby.
 */
class BrevoTransport extends AbstractTransport
{
    public function __construct(protected ?string $apiKey)
    {
        parent::__construct();
    }

    protected function doSend(SentMessage $message): void
    {
        if (empty($this->apiKey)) {
            throw new TransportException('BREVO_API_KEY is not set.');
        }

        $email = MessageConverter::toEmail($message->getOriginalMessage());
        $from = $email->getFrom()[0] ?? $message->getEnvelope()->getSender();

        $payload = [
            'sender' => $this->formatAddress($from),
            'to' => $this->formatAddresses($email->getTo()),
            'subject' => (string) $email->getSubject(),
        ];

        // Brevo requires a "to" list; fall back to the envelope recipients (e.g. BCC-only mail).
        if (empty($payload['to'])) {
            $payload['to'] = $this->formatAddresses($message->getEnvelope()->getRecipients());
        }
        if ($cc = $this->formatAddresses($email->getCc())) {
            $payload['cc'] = $cc;
        }
        if ($bcc = $this->formatAddresses($email->getBcc())) {
            $payload['bcc'] = $bcc;
        }
        if ($replyTo = ($email->getReplyTo()[0] ?? null)) {
            $payload['replyTo'] = $this->formatAddress($replyTo);
        }
        if ($html = $email->getHtmlBody()) {
            $payload['htmlContent'] = is_resource($html) ? stream_get_contents($html) : (string) $html;
        }
        if ($text = $email->getTextBody()) {
            $payload['textContent'] = is_resource($text) ? stream_get_contents($text) : (string) $text;
        }

        $attachments = [];
        foreach ($email->getAttachments() as $attachment) {
            $attachments[] = [
                'name' => $attachment->getFilename() ?: 'attachment',
                'content' => base64_encode($attachment->getBody()),
            ];
        }
        if ($attachments) {
            $payload['attachment'] = $attachments;
        }

        $response = Http::withHeaders([
            'api-key' => $this->apiKey,
            'accept' => 'application/json',
        ])->timeout(20)->post('https://api.brevo.com/v3/smtp/email', $payload);

        if (! $response->successful()) {
            throw new TransportException(
                'Brevo API error ('.$response->status().'): '.$response->body()
            );
        }
    }

    protected function formatAddress(Address $address): array
    {
        $data = ['email' => $address->getAddress()];
        if ($address->getName() !== '') {
            $data['name'] = $address->getName();
        }

        return $data;
    }

    protected function formatAddresses(array $addresses): array
    {
        return array_map(fn (Address $a) => $this->formatAddress($a), array_values($addresses));
    }

    public function __toString(): string
    {
        return 'brevo';
    }
}
