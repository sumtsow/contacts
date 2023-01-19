<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return response()->json(Group::where('parent_id', null)->orderBy('title')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
			return response()->json(Group::where('id', $id)->with('subscriber', 'parent', 'children')->get());
    }

    /**
     * Update existing or store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGroupRequest  $request
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
