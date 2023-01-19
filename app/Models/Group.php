<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	use HasFactory;
	protected $table = 'group';
	protected $with = ['children', 'subscriber'];
    
	public function subscriber()
	{
      return $this->hasMany(Subscriber::class);
	}

	public function parent()
	{
      return $this->belongsTo(self::class, 'parent_id');
	}

	public function children()
	{
      return $this->hasMany(self::class, 'parent_id');
	}
}
