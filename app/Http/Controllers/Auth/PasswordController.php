<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User\UserRepository;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    use ResetsPasswords;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Create a new password controller instance.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

        $this->middleware('guest');
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->setPassword($password);

        // Store Immediately otherwise \Auth::login() cannot find this user
        $this->userRepository->storeImmediately($user);

        \Auth::login($user);
    }
}
