<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdOfferView extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_offer_id',
        'user_id',
    ];
}
