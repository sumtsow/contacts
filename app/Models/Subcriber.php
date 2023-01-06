<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcriber extends Model
{
    use HasFactory;
    protected $table = 'subscriber';
    
    public function contact()
	{
      return $this->hasMany(Contact::class);
	}

    public function group()
	{
      return $this->belongsTo(Group::class);
	}
}
