<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login into the application
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($user = $this->attemptLogin($request)) {
            return $this->sendLoginResponse($user);
        }

        $this->sendFailedLoginResponse();
    }

    /**
     * Logout of the applilcation
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->attemptLogout($request);

        return $this->sendLogoutResponse();
    }

    /**
     * Get the information about the currently logged in user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        return response()->json([
            'data' => $request->user()
        ], 200);
    }

    /**
     * Attempt to logout the user from the application
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function attemptLogout(Request $request)
    {
        if ($user = $request->user()) {
            $user->api_token = null;

            $user->save();
        }
    }

    /**
     * Send a json response to logout
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLogoutResponse()
    {
        return response()->json([
            'message' => 'logout successful'
        ], 200);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $messages = require(resource_path('lang/en/validation.php'));

        $this->validate($request, [
            $this->username() => 'required|email',
            'password' => 'required',
        ], $messages);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return null|\App\User
     */
    protected function attemptLogin(Request $request)
    {
        $username = $request->input($this->username());
        $password = $request->input('password');

        $user = User::firstWhere($this->username(), $username);

        if ($user && Hash::check($password, $user->password)) {
            $user->api_token = base64_encode(Str::random(40));
            $user->save();

            return $user;
        }
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(User $user)
    {
        return response()->json([
            'message' => 'login successful',
            'data' => [
                'api_token' => $user->api_token
            ],
        ], 200);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Get the failed login response instance.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse()
    {
        throw ValidationException::withMessages([
            $this->username() => ["invalid {$this->username()} or password"],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }
}
