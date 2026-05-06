<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ThrottleLogin
{
    private const MAX_ATTEMPTS = 3;
    private const LOCKOUT_SECONDS = 10;
    private const CACHE_DURATION = 3600; // 1 hora

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Solo aplicar al POST de login
        if ($request->getMethod() !== 'POST' || !str_contains($request->path(), 'login')) {
            return $next($request);
        }

        $email = $request->input('email', '');
        $lockKey = 'login_locked:' . md5($email);
        $attemptsKey = 'login_attempts:' . md5($email);

        // Verificar si el usuario está bloqueado
        if (Cache::has($lockKey)) {
            return redirect()->route('login')
                ->withInput($request->except('password'))
                ->with('error', 'Demasiados intentos fallidos. Espera 10 segundos antes de intentar de nuevo.');
        }

        // Obtener número de intentos actuales
        $attempts = Cache::get($attemptsKey, 0);

        // Si ya alcanzó 3 intentos, bloquear
        if ($attempts >= self::MAX_ATTEMPTS) {
            Cache::put($lockKey, true, now()->addSeconds(self::LOCKOUT_SECONDS));
            Cache::forget($attemptsKey);
            return redirect()->route('login')
                ->withInput($request->except('password'))
                ->with('error', 'Demasiados intentos fallidos. Espera 10 segundos antes de intentar de nuevo.');
        }

        // Proceder con la solicitud
        $response = $next($request);

        // Verificar si la autenticación falló (redirección a login sin autenticar)
        if ($response instanceof \Illuminate\Http\RedirectResponse) {
            $targetUrl = $response->getTargetUrl();

            // Si redirige a login, incrementar intentos
            if (str_contains($targetUrl, 'login')) {
                $newAttempts = $attempts + 1;
                Cache::put($attemptsKey, $newAttempts, now()->addSeconds(self::CACHE_DURATION));

                // Redirigir a login con mensaje de error
                return redirect()->route('login')
                    ->withInput($request->except('password'))
                    ->with('error', 'Credenciales inválidas. Intento ' . $newAttempts . ' de ' . self::MAX_ATTEMPTS);
            }
        }

        // Si el login fue exitoso, limpiar intentos
        Cache::forget($attemptsKey);
        Cache::forget($lockKey);

        return $response;
    }
}


