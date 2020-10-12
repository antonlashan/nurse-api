<?php

/**
 * Description of Firebase.
 *
 * @author lashanfernando
 */

namespace App\Http;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Exception\Messaging\InvalidMessage;
use Kreait\Firebase\Exception\Messaging\NotFound;

class Firebase
{
    private $firebase;

    public function __construct()
    {
        // This assumes that you have placed the Firebase credentials in the same directory
        // as this PHP file.
        $serviceAccount = ServiceAccount::fromJsonFile(base_path().'/firebase_credentials.json');
        $this->firebase = (new Factory())
                ->withServiceAccount($serviceAccount)
                ->create();
    }

    public function sendNotification($token, $title, $body)
    {
        $messaging = $this->firebase->getMessaging();

        $notification = Notification::fromArray([
                    'title' => $title,
                    'body' => $body,
        ]);

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification);

        try {
            return $messaging->send($message);
        } catch (InvalidMessage $ex) {
        } catch (NotFound $e) {
        }
    }

    public function sendNotifications($deviceTokens, $title, $body)
    {
        $messaging = $this->firebase->getMessaging();

        $message = CloudMessage::fromArray([
            'notification' => [
                    'title' => $title,
                    'body' => $body,
        ],
        ]);

        try {
            return $messaging->sendMulticast($message, $deviceTokens);
        } catch (InvalidMessage $ex) {
        } catch (NotFound $e) {
        }
    }
}
