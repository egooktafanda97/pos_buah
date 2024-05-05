<?php

namespace Captain\module\services;


use Captain\module\services\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use InvalidArgumentException;

class OAuthService
{
    private Authentication $authentication;

    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    public function redirect()
    {
        $state = Str::random(40);


        $query = http_build_query([
            'client_id' => env("OAUTH_ClIENT_ID"),
            'redirect_uri' => env("OAUTH_REDIRECT"),
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
        ]);

        // Generate a unique identifier for the popup window
        //        return response()->json([
        //            'url' => env("OAUTH_SERVER") . '/oauth/authorize?' . $query,
        //            'state' => $state,
        //        ]);
        return redirect(env("OAUTH_SERVER") . '/oauth/authorize?' . $query);
    }

    public function callback(Request $request)
    {
        $state = $request->state;
        throw_unless(
            strlen($state) > 0 && $state === $request->state,
            InvalidArgumentException::class,
            'Invalid state value.'
        );

        $response = Http::asForm()->post(env("OAUTH_SERVER") . '/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => env("OAUTH_ClIENT_ID"),
            'client_secret' => env("OAUTH_ClIENT_SC"),
            'redirect_uri' => env("OAUTH_REDIRECT"),
            'code' => $request->code,
        ]);

        if ($response->failed()) abort(401);

        $getMe = Http::withToken($response->json()["access_token"])->get(env("OAUTH_SERVER") . '/api/me');
        $users = $getMe->json();
        $result = [
            ...$response->json(),
            ...$getMe->json(),
            ...$users,
            "oauth_id" => $users['id'],
        ];
        $login = $this->authentication->authSso(new Request($result));
        if (!$login && !auth()->user()) abort(401);
        session()->put('user_login', $login);
        return redirect('/test');
        //        $jsonResponse = $response->json();
        //        Redis::set("creditial", $response->json());
        //        echo '<script>window.opener.postMessage(' . json_encode($jsonResponse) . ', "*"); window.close();</script>';
        //        return $response->json();
    }

    public function authWithToken(Request $request)
    {
        $response = Http::asForm()->post(env("OAUTH_SERVER") . '/oauth/token', [
            'grant_type' => 'password',
            'client_id' => env("OAUTH_ClIENT_ID_TOKEN"),
            'client_secret' => env("OAUTH_ClIENT_SC_TOKEN"),
            'username' => $request->username,
            'password' => $request->password,
            'scope' => '',
        ]);
        if ($response->failed()) abort(401);
        $getMe = Http::withToken($response->json()["access_token"])->get(env("OAUTH_SERVER") . '/api/me');
        $users = $getMe->json();
        $result = [
            ...$response->json(),
            "oauth_id" => $users['id'],
        ];

        $login = $this->authentication->authSsoApi(new Request($result));
        if (!$login && !auth()->user()) abort(401);
        return $login;
    }
}
