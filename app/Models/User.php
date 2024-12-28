<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'facebook_id',
        'google_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
            'is_super_admin' => 'boolean',
            'is_banned' => 'boolean'
        ];
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'user_permission');
    }

    public function findForPassport(string $username): User
    {
        return $this->where('username', $username)->first();
    }

    public function validateForPassportPasswordGrant(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

    public function scopeShowUserDetails($query, $id) {
        return $query->where('id', $id);
    }

    public function scopeCheckUsernameExist($query, string $username) {
        return $query->where('username', $username);
    }

    public function scopeFindUserByRole($query, $role) {
        return $query->whereIn('role', $role);
    }

    public function scopeFindUserByName($query, $name) {
        return $query->whereLike('name', "$name%");
    }

    public function scopeFindUserByUsername($query, $username) {
        return $query->whereLike('username', "$username%");
    }

    public function scopeFindUserByEmail($query, $email) {
        return $query->whereLike('email', "$email%");
    }

    public function scopeFindUserBanned($query, $is_banned) {
        return $query->whereIn('is_banned', $is_banned);
    }

}
