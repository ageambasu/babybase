<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller {

    protected function guard() {
        return \Illuminate\Support\Facades\Auth::guard();
    }

    public function showLoginForm() {
        $oauth_url = config('oauth.auth_url')."?"."response_type=code"."&client_id=".urlencode(config('oauth.client_id'))
                ."&scope=".urlencode(config('oauth.scope'))
                ."&redirect_uri=".urlencode(config('oauth.callback_url'));
        return view('auth.login_ulcn', ['oauth_url' => $oauth_url]);
    }

    public function logout() {
        $this->guard()->logout();
        return redirect('/');
    }

    public function oauth(Request $request) {
        $code = $request->get('code');
        try {
            $token = $this->getToken($code);
            $userinfo = $this->getUserInfo($token);
        }
        catch(Exception $e) {
            return redirect('/');
        }

        if (!isset($userinfo['ULCNuid'])) {
            return redirect('/');
        }

        $user = \App\User::where('ulcn_uid', $userinfo['ULCNuid'])->first();
        if (!$user) {
            \App\User::create([
                'ulcn_uid' => $userinfo['ULCNuid'],
                'name' => $userinfo['ULCNdisplayName'],
                'email' => $userinfo['ulcnmailCorrespondence'],
                'isAdmin' => false,
                'active' => false,
                'password' => '',
            ]);
            return redirect('/pending');
        }
        else if (!$user->active) {
            return redirect('/pending');
        }

        $this->guard()->loginUsingId($user->id);
        return redirect('/');
    }

    private function getToken($code) {
        $curl = curl_init();
        $params = array(
            CURLOPT_URL => config('oauth.access_token_url'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_NOBODY => false,
            CURLOPT_POSTFIELDS =>
            "code=".$code
            ."&grant_type=authorization_code"
            ."&client_id=". config('oauth.client_id')
            ."&client_secret=". config('oauth.client_secret')
            ."&redirect_uri=". config('oauth.callback_url')
            ."&scope=".urlencode(config('oauth.scope')),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "accept: *"));

        curl_setopt_array($curl, $params);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #01: " . $err;
        } else {
            $response = json_decode($response, true);
            if(array_key_exists("access_token", $response)) return $response['access_token'];
            if(array_key_exists("error", $response)) echo $response["error_description"];
            echo "Error fetching user token\n";
            echo "cURL Error #02: Something went wrong! Please contact admin.";
        }
    }

    private function getUserInfo($token) {
        $curl = curl_init();
        $params = array(
            CURLOPT_URL => config('oauth.user_info_url'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_NOBODY => false,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $token",
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "accept: *"));

        curl_setopt_array($curl, $params);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #01: " . $err;
        } else {
            $response = json_decode($response, true);
            return $response;
            if(array_key_exists("error", $response)) echo $response["error_description"];
            echo "Error fetching user info\n";
            echo "cURL Error #02: Something went wrong! Please contact admin.";
        }
    }
}
