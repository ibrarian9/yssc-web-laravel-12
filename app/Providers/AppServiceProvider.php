<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(Login::class, function (Login $event) {
            if (! $event->user instanceof User) {
                return;
            }

            $user = $event->user;
            $meta = [
                'ip' => request()?->ip(),
                'user_agent' => request()?->userAgent(),
                'role' => $user->role?->value,
            ];

            if (! $user->is_active) {
                activity('auth')
                    ->performedOn($user)
                    ->causedBy($user)
                    ->event('failed')
                    ->withProperties($meta)
                    ->log("Login ditolak (akun nonaktif): {$user->email}");

                return;
            }

            activity('auth')
                ->performedOn($user)
                ->causedBy($user)
                ->event('login')
                ->withProperties($meta)
                ->log("Login berhasil: {$user->name} ({$user->role->label()})");
        });

        Event::listen(Logout::class, function (Logout $event) {
            if (! $event->user instanceof User || ! $event->user->is_active) {
                return;
            }

            $user = $event->user;
            activity('auth')
                ->performedOn($user)
                ->causedBy($user)
                ->event('logout')
                ->withProperties([
                    'ip' => request()?->ip(),
                    'user_agent' => request()?->userAgent(),
                    'role' => $user->role?->value,
                ])
                ->log("Logout: {$user->name}");
        });

        Event::listen(Failed::class, function (Failed $event) {
            $email = (string) ($event->credentials['email'] ?? '-');
            $matchedUser = $event->user instanceof User
                ? $event->user
                : User::where('email', $email)->first();

            $logger = activity('auth')
                ->causedByAnonymous()
                ->event('failed')
                ->withProperties([
                    'email' => $email,
                    'ip' => request()?->ip(),
                    'user_agent' => request()?->userAgent(),
                ]);

            if ($matchedUser) {
                $logger->performedOn($matchedUser);
            }

            $logger->log("Login gagal (kredensial salah): {$email}");
        });
    }
}
