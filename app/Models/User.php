<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'role_id'
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

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function testResults()
    {
        return $this->hasMany(TestResult::class);
    }

    public function isAdmin(): bool
    {
        return $this->role && $this->role->name === 'admin';
    }

    public function isModerator(): bool
    {
        return $this->role && $this->role->name === 'moderator';
    }

    /**
     * Check if the user has one of the given roles.
     * Accepts a string or an array of role names.
     */
    public function hasRole(string|array $roles): bool
    {
        if (! $this->role) {
            return false;
        }

        $name = $this->role->name;

        if (is_array($roles)) {
            return in_array($name, $roles, true);
        }

        return $name === $roles;
    }

    public function canTakeTest(Test $test): bool
    {
        if ($test->is_final_exam) {
            return $this->testResults()
                ->whereHas('test', function ($query) {
                    $query->where('is_final_exam', false);
                })
                ->where('passed', true)
                ->count() === Test::where('is_final_exam', false)->count();
        }

        if ($test->required_tests->isEmpty()) {
            return true;
        }

        foreach ($test->required_tests as $requiredTest) {
            if (!$this->testResults()
                ->where('test_id', $requiredTest->id)
                ->where('passed', true)
                ->exists()) {
                return false;
            }
        }

        return true;
    }
}
