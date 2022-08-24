<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    protected $fillable = [
        'suhu_tubuh',
        'name_id',
        'image_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'name_id');
    }

    public function pap(){
        return $this->belongsTo(Pap::class, 'image_id');
    }
}
