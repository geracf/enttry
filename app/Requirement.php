<?php

namespace App;

use App\Offer;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
