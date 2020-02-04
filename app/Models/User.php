<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Airlock\HasApiTokens;
use App\Jobs\SendResetPasswordEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    use HasApiTokens;

    protected $guarded = ['id'];
    protected $hidden = ['password', 'remember_token', 'is_admin', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'is_admin' => 'boolean',
        'email_confirmed' => 'boolean',
    ];

    protected $fillable = [
        'first_name', 'last_name', 'email', 'is_admin', 'organization_id', 'token', 'picture', 'sso_id'
    ];

    public $searchable = [
        'first_name', 'last_name', 'email'
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
            $user->token = Str::random(30);
        });
    }

    /**
     * Use The Token To Identify The User In Routes
     */
    public function getRouteKeyName()
    {
        return 'token';
    }

    /***************************************************************************************
     ** SCOPES
     ***************************************************************************************/

    public function scopeByEmail($query, string $email)
    {
        return $query->where('email', $email);
    }

    public function scopeByToken($query, string $token)
    {
        return $query->where('token', $token);
    }

    /***************************************************************************************
     ** RELATIONS
     ***************************************************************************************/

    public function profileable()
    {
        return $this->morphTo();
    }

    /***************************************************************************************
     ** CRUD
     ***************************************************************************************/

    public static function makeOne(array $data)
    {
        $user = new User;
        $user->fill($data);
        $user->password = Hash::make($data['password']);
        $user->save();

        return $user;
    }

    public function updateMe(array $data)
    {
        //  name
        if (Arr::get($data, 'first_name') && Arr::get($data, 'last_name')) {
            $this->first_name = $data['first_name'];
            $this->last_name = $data['last_name'];
        }

        // email
        if (Arr::get($data, 'email')) {
            $this->email = $data['email'];
        }

        // password
        if (Arr::get($data, 'new_password')) {
            $this->password = bcrypt($data['new_password']);
        }

        $this->save();
    }

    public function updatePassword(string $password)
    {
        $this->password = Hash::make($password);
        $this->save();
    }

    /***************************************************************************************
     ** GETTERS
     ***************************************************************************************/

    public function getName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function isProvider()
    {
        return $this->profileable_type === Provider::class;
    }

    public function isSameAs(Model $profileable)
    {
        if ($this->profileable_id !== $profileable->id) {
            return false;
        }
        if ($this->profileable_type !== get_class($profileable)) {
            return false;
        }
        return true;
    }

    /***************************************************************************************
     ** SETTERS
     ***************************************************************************************/

    public function setEmailConfirmed()
    {
        $this->email_confirmed = true;
        $this->save();
    }

    public function getTimezone()
    {
        // todo
        return 'America/New_York';
    }

    /***************************************************************************************
     ** OVERRIDES
     ***************************************************************************************/

    public function sendPasswordResetNotification($token)
    {
        SendResetPasswordEmail::dispatch($this, $token, true);
    }
}
