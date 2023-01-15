<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Type extends Model
{
	use HasFactory;
	protected $table = 'type';

	public function contact()
	{
		return $this->hasMany(Contact::class);
	}

	public static function getInputTypes()
    {
      return explode(',',str_replace("'", "", substr(DB::select(DB::raw('DESCRIBE `type` `input_type`'))[0]->Type,5,-1)));
    }
}
