<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($all = null)
    {
			$query = Group::orderBy('title');
			if (!$all) $query->where('parent_id', null);
      return response()->json($query->get());
    }

    /**
     * Update existing or store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request, int $id)
    {
      if ($id) {
        $group = Group::findOrFail($id);
      } else {
        $group = new Group();
      }
      $group->title = $request->title;
      $group->enabled = intval($request->enabled);
      $group->parent_id = $request->parent_id ? intval($request->parent_id) : null;
			if ($group->parent_id !== $id) $group->save();
      return response()->json([ $group->id ]);
    }
}
