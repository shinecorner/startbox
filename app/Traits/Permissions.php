<?php namespace App\Traits;

use Auth;
use Log;

trait Permissions
{
    public function belongsToAuthenticated()
    {
        if ($this->user_id == Auth::user()->id) {
            return true;
        }
        return false;
    }

    public function userCanView()
    {
        if ($this->belongsToAuthenticated()) {
            return true;
        }
    }
}
