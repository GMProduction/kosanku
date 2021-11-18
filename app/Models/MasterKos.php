<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterKos extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'nama',
      'keterangan',
      'foto',
      'latitude',
      'longtitude',
      'peruntukan',
      'harga',
      'alamat',
      'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function rating(){
        return $this->hasMany(Rating::class, 'kos_id');
    }
}
