<?php

namespace App\Models;

use Laravel\Airlock\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Jobs\SendResetPasswordEmailAdmin;

class Admin extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    use HasApiTokens;

    protected $hidden = ['password', 'remember_token'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'first_name', 'last_name', 'email', 'status', 'avatar'
    ];

    public $searchable = [
        'first_name', 'last_name', 'email', 'status'
    ];

    public function toSearchableArray()
    {
        return array_flip($this->searchable);
    }

    public function getSearchableArray()
    {
        return $this->searchable;
    }

    /***************************************************************************************
     ** MODS
     ***************************************************************************************/

    public static function boot()
    {
        parent::boot();
        static::creating(function ($user) {

        });
    }


    public function updatePassword(string $password)
    {
        $this->password = Hash::make($password);
        $this->save();
    }

    public function scopeByEmail($query, string $email)
    {
        return $query->where('email', $email);
    }

    /***************************************************************************************
     ** GETTERS
     ***************************************************************************************/

    public function getName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getTimezone()
    {
        // TODO
        return 'America/New_York';
    }

    public function isAdmin()
    {
        // TODO
        return true;
    }

    public function sendPasswordResetNotification($token)
    {
        SendResetPasswordEmailAdmin::dispatch($this, $token, true);
    }
}
