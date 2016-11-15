<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OOD\Users\Device;

class DeviceController extends ApiController
{
    /**
     * Register a device for a user.
     * 
     * @param  Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        // Get or create the device.
        $device = Device::firstOrNew([
            'device_id' => $request->device_id,
            'user_id' => Auth::user()->id,
            'token' => $request->token,
        ]);

        // Set the device platform and make sure it is active.
        $device->is_registered = 1;
        $device->platform = $request->platform;

        // Save the device back to the user.
        Auth::user()->devices()->save($device);

        // Respond with the users registered devices.
        return $this->respond([
            'data' => Auth::user()->devices
        ]);
    }
}
