<?php

/**
 * Description of SMS.
 *
 * @author lashanfernando
 */

namespace App\Http;

use GuzzleHttp\Client;

class SMS
{
    const ENDPOINT = 'https://api.getshoutout.com';

    private $apiKey;
    private $senderId;
    private $client;
    private $options;

    public function __construct()
    {
        $this->apiKey = env('SMS_KEY');
        $this->senderId = env('SMS_SENDER_ID');
        $this->client = new Client(['base_uri' => static::ENDPOINT]);
        $this->options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Apikey '.$this->apiKey,
            ],
        ];
    }

    public function OTPSend($phone)
    {
        $body = [
            'source' => $this->senderId,
            'destination' => $phone,
            'content' => [
                'sms' => 'Please use this OTP {{code}} for verify phone number.',
            ],
            'transport' => 'sms',
        ];
        $this->options['json'] = json_encode($body);

        $result = $this->client->post('otpservice/send', $this->options);

        return json_decode($result->getBody()->getContents());
    }

    public function OTPVerify($refId, $code)
    {
        $body = [
            'code' => $code,
            'referenceId' => $refId,
        ];
        $this->options['json'] = json_encode($body);

        $result = $this->client->post('otpservice/verify', $this->options);

        return json_decode($result->getBody()->getContents());
    }

    public function sendSMS($phoneNos, $bodyContent)
    {
        $body = [
            'source' => $this->senderId,
            'destinations' => $phoneNos,
            'content' => [
                'sms' => $bodyContent,
            ],
            'transports' => ['sms'],
        ];
        $this->options['body'] = json_encode($body);

        $result = $this->client->post('coreservice/messages', $this->options);

        return json_decode($result->getBody()->getContents());
    }
}
