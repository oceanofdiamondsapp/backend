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
            $payload = PushNotification::Message($message, array(
                'sound' => 'default',
//                'badge' => 1,
            ));
            PushNotification::app('appNameIOS')
                ->to($device->token)
                ->send($payload);
        }
    }
}
