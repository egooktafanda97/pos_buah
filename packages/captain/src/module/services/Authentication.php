<?php

namespace Captain\module\services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Captain\module\repository\Users\UserRepositoryInterface;

/**
 * class helper untuk mengurai organisme role dan module
 */
class Authentication
{

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    function securityCreditialUsername($request)
    {

        $username = $this->userRepository::UserNameCheck('wilma.dietrich');
        return $username;
        if (!$username)
            throw new AuthenticationException('Invalid username');
        return $username;
    }

    public function authWithToken($request)
    {
        try {
            $this->securityCreditialUsername($request);
            $exp = 1440;
            if ($request->remember_me)
                $exp = $this->expires_in_remember();
            if (!$token = auth()->guard("api")->setTTL($exp)->attempt($request->all())) {
                throw new AuthenticationException('Invalid credentials');
            }
            return $this->respondWithToken($token);
        } catch (AuthenticationException $e) {
            throw $e;
        }
    }

    public function expires_in_remember()
    {
        return 1440 * 30;
    }

    protected function respondWithToken($token)
    {
        return collect([
            'token' => $token,
            'token_type' => 'bearer',
            //            'permission' => auth("api")->user()->getRoleNames()[0] ?? false,
            "users" => auth("api")->user()
        ]);
    }

    public function auth($request)
    {
        try {
            $this->securityCreditialUsername($request);
            $credentials = $request->only('username', 'password');
            if (Auth::attempt($credentials)) {
                return Auth::user();
            }
            throw new AuthenticationException('Invalid credentials');
        } catch (AuthenticationException $e) {
            throw $e;
        }
    }

    public function authSso($request)
    {
        try {
            $users = $this->userRepository::getUserSsoCheck('oauth_id', $request->oauth_id);
            if (!$users)
                throw new AuthenticationException('Invalid credentials');
            Auth::login($users);
            return [
                ...collect($request->all())->except(['password'])->toArray(),
                "users" => auth()->user()
            ];
        } catch (AuthenticationException $e) {
            throw $e;
        }
    }

    public function authSsoApi($request)
    {
        try {
            $users = $this->userRepository::getUserSsoCheck('oauth_id', $request->oauth_id);
            $exp = 1440;
            if ($request->remember_me)
                $exp = $this->expires_in_remember();
            $token = auth()->guard("api")->setTTL($exp)->login($users);
            if (!$token) {
                throw new AuthenticationException('Invalid credentials');
            }
            return [
                ...collect($request->all())->except(['password'])->toArray(),
                ...$this->respondWithToken($token)
            ];
        } catch (AuthenticationException $e) {
            throw $e;
        }
    }
}
