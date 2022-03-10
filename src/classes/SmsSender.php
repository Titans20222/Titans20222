<?php
#use vendor\twilio\src\twilio\Rest\Client;
namespace classes\SmsSender;

use Twilio\Rest\Client;

class SmsSender {


#$token='your_twilio_token';
#$twilioNumber = 'your_twilio_number';

// /**
//     * @var Client
//     */
//    private Client $client;
//
//    public function __construct(Client $client)
//    {
//        $this->client = $client;
//    }

    public function __invoke(string $toNumber, array $payload): void
    {
        $this->client->messages->create($toNumber, $payload);
    }
}