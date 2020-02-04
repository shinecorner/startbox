<?php

namespace App\Traits;

trait DefinesUpdate
{
    public function updateMe(array $data)
    {
        $filtered = array_filter(array_only($data, $this->updatable));
        $this->update($filtered);
    }
}
