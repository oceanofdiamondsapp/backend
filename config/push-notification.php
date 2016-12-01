<?php

return array(

    'appNameIOS'     => array(
        'environment' =>'production',
        'certificate' =>'aps-ood-prod.pem',
        'passPhrase'  =>'',
        'service'     =>'apns'
    ),
    'appNameAndroid' => array(
        'environment' =>'production',
        'apiKey'      =>env('GCM_API_KEY'),
        'service'     =>'gcm'
    )

);