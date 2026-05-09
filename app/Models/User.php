<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\CustomConfirmPassword;
use App\Notifications\CustomResetPassword;
use App\Notifications\CustomVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Send a password reset notification to the user.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new CustomResetPassword($token));
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new CustomVerifyEmail());
    }

    /**
     * Send a confirmation password notification to the user.
     */
    public function sendConfirmPasswordNotification(): void
    {
        $this->notify(new CustomConfirmPassword());
    }

    public function estudiante()
    {
        return $this->HasOne(Estudiante::class);
    }
    public function personal()
    { //relacion 1 a 1
        return $this->HasOne(Personal::class);
    }
}
