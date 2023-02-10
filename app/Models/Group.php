<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	use HasFactory;
	protected $table = 'group';
	protected $with = ['children'];
    
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

	public static function getList()
	{
		$groups = self::orderBy('title')->where('parent_id', null)->get();
		$list = [];
		foreach ($groups as $group) {
			$list = array_merge($list, self::getChildList($group));
		}
    return $list;
	}

	private static function getChildList($group) {
		$list = [];
		$list[] = $group->id;
		foreach ($group->children as $child) {
			$list = array_merge($list, self::getChildList($child));
		}
		return $list;
	}

	public static function getPageGroups($page = [])
	{
		if (!$page) return [];
		$groups = [];
		foreach ($page->items() as $subscriber) {
			if (!isset($groups[$subscriber->group_id])) $groups[$subscriber->group_id] = $subscriber->group;
		}
    return $groups;
	}
}
