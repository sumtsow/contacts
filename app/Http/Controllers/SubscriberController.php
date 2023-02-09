<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Subscriber;
use App\Http\Requests\StoreSubscriberRequest;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
		 * @param  int  $groupped
		 * @param  int  $gid group id
     * @return \Illuminate\Http\Response
     */
    public function index(int $groupped = 0, int $gid = 0)
    {
			$groupOrder = [];
			if ($groupped) {
				$query = Subscriber::orderBy('group_id');
				//$groups = Group::orderBy('title')->where('parent_id', null);
			} else {
				$query = Subscriber::orderBy('id', 'desc');
			}
			if ($groupped && $gid) $query->where('group_id', $gid);
      return response()->json($query->paginate(config('app.perpage')));
    }

    /**
     * Update existing or store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubscriberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscriberRequest $request, int $id)
    {
      if ($id) {
        $subscriber = Subscriber::findOrFail($id);
      } else {
        $subscriber = new Subscriber();
      }
			$subscriber->group_id = $request->group_id;
      $subscriber->firstname = $request->firstname;
			$subscriber->lastname = $request->lastname ?? '';
      $subscriber->enabled = intval($request->enabled);
			$subscriber->save();
			$subscriber->group;
			$subscriber->contact;
      return response()->json([ $subscriber ]);
    }
}
