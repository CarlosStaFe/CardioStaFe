<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class ResetPasswordController extends Controller
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
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get the password reset validation rules.
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', 'min:8', 'string'],
        ];
    }

    /**
     * Get the password reset validation error messages.
     */
    protected function validationErrorMessages()
    {
        return [
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección válida.',
            'token.required' => 'El token de restablecimiento es obligatorio.',
        ];
    }

    /**
     * Reset the given user's password.
     */
    protected function resetPassword($user, $password)
    {
        Log::info('Password reset: iniciando reset para usuario', ['email' => $user->email]);
        
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        Log::info('Password reset: contraseña actualizada exitosamente', ['email' => $user->email]);
    }

    /**
     * Get the response for a successful password reset.
     */
    protected function sendResetResponse(Request $request, $response)
    {
        Log::info('Password reset: enviando respuesta exitosa');
        
        return redirect()->route('login')
            ->with('status', 'Su contraseña ha sido restablecida correctamente. Ya puede iniciar sesión con su nueva contraseña.');
    }

    /**
     * Get the response for a failed password reset.
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        Log::error('Password reset: falló el reset de contraseña', ['response' => $response]);
        
        return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
    }
}
