<?php
namespace Scherersoftware\CakePushNotifications\Lib;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use ZendService\Apple\Apns\Client\Message as ApnsClient;
use ZendService\Apple\Apns\Message as ApnsMessage;
use ZendService\Apple\Apns\Message\Alert as ApnsAlert;
use ZendService\Apple\Apns\Response\Message as ApnsResponse;
use ZendService\Apple\Exception\RuntimeException as ApnsRuntimeException;
use ZendService\Google\Gcm\Client as GcmClient;
use ZendService\Google\Gcm\Message as GcmMessage;
use ZendService\Google\Exception\RuntimeException as GcmRuntimeException;

class PushNotificationFactory
{

    public $client = null;

    public $message = null;

    public function __construct($platform) {
        switch ($platform) {
            case 'ios':
                $this->client = new ApnsClient();
                $this->client->open(ApnsClient::SANDBOX_URI, Configure::read('CakePushNotifications.ios.sandboxCertificate'));

                $this->message = new ApnsMessage();
                return $this;
            case 'android':
                $this->client = new GcmClient();
                $this->client->setApiKey(Configure::read('CakePushNotifications.android.apiKey'));

                $this->message = new GcmMessage();
                return $this;
            default:
                throw new \Exception("You need to pass a platform string, 'android' or 'ios'");
        }
    }

    public function send() {
        if (is_a($this->client, 'ZendService\Apple\Apns\Client\Message')) {
            $this->__sendIos();
        }
        if (is_a($this->client, 'ZendService\Google\Gcm\Client')) {
            $this->__sendAndroid();
        }
    }

    private function __sendAndroid()
    {
        try {
            $response = $this->client->send($this->message);
        } catch (GcmRuntimeException $e) {
            echo $e->getMessage() . PHP_EOL;
            exit(1);
        }
        TableRegistry::get('Scherersoftware/CakePushNotifications.Feedback')->processResponse($response);
    }

    private function __sendIos()
    {
        try {
            $response = $this->client->send($this->message);
        } catch (ApnsRuntimeException $e) {
            echo $e->getMessage() . PHP_EOL;
            exit(1);
        }
        $this->client->close();
        TableRegistry::get('Scherersoftware/CakePushNotifications.Feedback')->processResponse($response);
    }
}
