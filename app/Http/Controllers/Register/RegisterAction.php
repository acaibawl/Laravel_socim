<?php
declare(strict_types=1);

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RegisterAction extends Controller
{
    public function __invoke(): RedirectResponse
    {
        return Socialite::driver('github')->redirect();
    }
}