<?php

namespace App\Models;

// extends
use Illuminate\Database\Eloquent\Model;

// includes
use App\Helpers\ToolKit;
use App\Events\EmailConfirmed;

class EmailConfirmation extends Model
{
    protected $table = 'email_confirmations';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at'];
    protected $casts = [
        'confirmed' => 'boolean',
    ];
    public $timestamps = true;

    /***************************************************************************************
     ** SCOPES
     ***************************************************************************************/

    public function scopeByEmail($query, string $email)
    {
        return $query->where('email', $email);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('confirmed', true);
    }

    public function scopeByToken($query, string $token)
    {
        return $query->where('token', $token);
    }

    /***************************************************************************************
     ** RELATIONS
     ***************************************************************************************/

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /***************************************************************************************
     ** CRUD
     ***************************************************************************************/

    public static function makeOne(User $user)
    {
        $emailConfirmation = new EmailConfirmation;
        $emailConfirmation->user_id = $user->id;
        $emailConfirmation->token = ToolKit::token(20);
        $emailConfirmation->email = $user->email;
        $emailConfirmation->save();
        return $emailConfirmation;
    }

    public function setConfirmed()
    {
        if (!$this->user->email_confirmed) {
            $this->user->setEmailConfirmed();
            event(new EmailConfirmed($this->user));
        }
        $this->confirmed = true;
        $this->save();
    }
}