<?php

namespace OOD\Services;
use PushNotification;

class PushNotificationService
{
    /**
     * Send a push notification to a device.
     *
     * @param deviceObjectt $device
     * @param string $message
     *
     * @return void
     */
    public static function send($device, $message)
    {
        if (strcasecmp($device->platform, 'android') == 0) {
            PushNotification::app('appNameAndroid')
                ->to($device->token)
                ->send($message);
        } else if (strcasecmp($device->platform, 'ios') == 0) {
            $payload = json_encode([
                'aps' => [
                    'alert' => $message,
                    'sound' => 'default',
                    'badge' => 1
                ]
            ]);
        }
    }

//        $notification = static::buildNotification($deviceToken, $payload);
//
//        $address = env('APNS_DEVELOPMENT', true)
//                   ? 'ssl://gateway.sandbox.push.apple.com:2195'
//                   : 'ssl://gateway.push.apple.com:2195';
//
//        $localCert = env('APNS_DEVELOPMENT', true)
//                     ? storage_path('app/aps_development.pem')
//                     : storage_path('app/aps_production.pem');
//
//        $context = stream_context_create();
//        stream_context_set_option($context, 'ssl', 'local_cert', $localCert);
//        stream_context_set_option($context, 'ssl', 'passphrase', env('APNS_CERT_PASSWORD'));
//        stream_context_set_option($context, 'ssl', 'cafile', storage_path('app/entrust_2048_ca.cer'));
//
//        $client = stream_socket_client($address, $errno, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $context);
//        fwrite($client, $notification);
//        fclose($client);
//    }

    /**
     * Encode the notification as required by the APNS service.
     *
     * @param string $deviceToken
     * @param string $payload
     *
     * @return string
     */
//    private static function buildNotification($deviceToken, $payload)
//    {
//        $notification =
//            chr(1)
//                . pack('n', 32)
//                . pack('H*', $deviceToken)
//            . chr(2)
//                . pack('n', strlen($payload))
//                . $payload
//            . chr(3)
//                . pack('n', 4)
//                . pack('N', time())
//            . chr(4)
//                . pack('n', 4)
//                . pack('N', time() + 86400)
//            . chr(5)
//                . pack('n', 1)
//                . chr(10);
//
//        return chr(2) . pack('N', strlen($notification)) . $notification;
//    }
}
