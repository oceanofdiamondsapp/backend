<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OOD\Users\User;
use OOD\Users\ForgotPassword;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends ApiController
{
    public function __construct()
    {
        // no middleware
    }

    /**
     * If the user passes the basic auth middleware, return
     * their data serialized as json.
     * 
     * @return OOD\Users\User
     */
    public function login(Request $request)
    {
        if (! Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->respondBadRequest([
                'error' => 'Invalid credentials'
            ]);
        }

        return $this->respond([
            'data' => Auth::user()
        ]);
    }

    public function logout(Request $request){
        if ($request->device_id != null)
            Auth::user()->devices()->where('device_id', $request->device_id)->delete();
        Auth::logout();
        return $this->respond(['success' => true]);
    }

    public function forgotPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()[0]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = DB::table('users')->where('email', $request->email)->get();

        if (count($user) == 0){
            return response()->json([
                'error' => 'Current email does not exist.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Generate Random URL
        do {
            $key = $this->RandomString();
            $query = DB::table('forgot_passwords')
                ->where( 'email', $request->email)
                ->where( 'key', $key) -> get();
        }while(count($query) > 0);

        $field = ForgotPassword::create([
            'email' => $request->email,
            'key' => $key,
            'bused' => 0
        ]);

        if ($field == null){
            return response()->json([
                'error' => 'ForgotPassword key registration was failed.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $linkUrl = env("APP_URL") . 'api/v1/auth/password/resetview?key=' . $key . '&email=' . $request->email;

        $data = [
            'user' => $user[0],
            'url' => $linkUrl
        ];

        $result = Mail::send('emails.forgotpassword', $data, function ($message) use($request, $user) {
            $message->from('info@oceanofdiamondsapp.com', 'Ocean of Diamonds');
            $message->to($request->email)->subject("Your Password Reset Link");
        });

        return response()->json([
            'success' => true
        ]);
    }

    public function resetPasswordView(Request $request){
        $query = ForgotPassword::where( 'email', $request->email)->get();
        foreach ($query as $field){
            if ($this->GetPassedDays($field->created_at) > 0) {
                $field -> delete();
            }
        }

        $query = ForgotPassword::where( 'key', $request->key) -> get();
        if (count($query) == 0 || $query[0]->email != $request->email)
            return 'This link does not exist any more.';

        $linkUrl = env("APP_URL") . 'api/v1/auth/password/reset';

        $query[0]->bused = 1;
        $query[0]->save();

        return view('emails.resetpassword', ['url' => $linkUrl, 'key' => $request->key, 'email' => $request->email]);
    }

    public function GetPassedDays($date){
        $now = time(); // or your date as well
        $your_date = strtotime($date);
        $datediff = $now - $your_date;
        return floor($datediff/(60*60*24));
    }

    function RandomString($length = 10)
    {
        $str = '';
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }

    public function resetPassword(Request $request){
        $query = ForgotPassword::where( 'key', $request->key)->get();
        if (count($query) == 0 || $query[0]->email != $request->email)
            return 'This link does not exist any more.';

        if (strlen($request->password) < 6) {
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors(['email' => 'Passwords must be at least six characters and match the confirmation.']);
        }else if ($request->password != $request->password_confirmation) {
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors(['email' => 'The password confirmation does not match.']);
        }

        $query[0]->delete();

        $user = User::where('email', $request->email)->get()->first();
        $user->password = bcrypt($request->password);
        $user->save();

        return 'The password has been changed successfully!';
    }
}
