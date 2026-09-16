<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Post;
use Laravel\Sanctum\HasApiTokens;
#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    
    use HasApiTokens, HasFactory, Notifiable;

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
    public function posts(){
        return $this->hasMany(Post::class);
    }
    public function profile()
    {
    return $this->hasOne(Profile::class);
    }
    public function courses()
    {
    return $this->belongsToMany(Course::class);
    }

    /**
     * Whether this user has the "admin" role. Used to gate access to the
     * Blade admin dashboard (see EnsureUserIsAdmin middleware). The "role"
     * column is intentionally left out of #[Fillable] above so it can never
     * be mass-assigned through registration or the admin "Add User" form.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
