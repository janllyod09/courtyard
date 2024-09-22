<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permits extends Model
{
    use HasFactory;

    protected $table = 'permits';

    protected $fillable = [
        'user_id',
        'permit_number',
        'mining_type',
        'permit_type',
        'location',
        'product',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
