<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Subscriber;
use App\Http\Requests\StoreSubscriberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
		 * @param  int  $groupped
		 * @param  int  $gid group id
		 * @param  Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(int $groupped = 0, int $gid = 0, Request $request)
    {
			$groups = [];
			$q = urldecode($request->query('q', false));
			$sortDir = $request->query('d', false);
			$sortDir = $sortDir ? 'desc' : 'asc';
			$sortOrder = $request->query('s', false);
			if ($groupped) {
				$groups = implode(', ', Group::getList());
				$query = Subscriber::orderByRaw('FIELD(`group_id`, ' . $groups . ')')->orderBy('lastname')->orderBy('firstname')->with('group');
			} else {
				switch ($sortOrder) {
					case 'n':
						$query = Subscriber::orderBy('lastname', $sortDir)->orderBy('firstname');
						break;
					case 'g':
						$query = Subscriber::orderBy('group_id', $sortDir)->orderBy('lastname', $sortDir)->orderBy('firstname');
						break;
					case 's':
						$query = Subscriber::orderBy('enabled', $sortDir)->orderBy('lastname', $sortDir)->orderBy('firstname');
						break;
					case 'c':
						$query = Subscriber::orderBy('created_at', $sortDir)->orderBy('lastname', $sortDir)->orderBy('firstname');
						break;
					case 'u':
						$query = Subscriber::orderBy('updated_at', $sortDir)->orderBy('lastname', $sortDir)->orderBy('firstname');
						break;
					case 'i':
					default:
						$query = Subscriber::orderBy('id', $sortDir)->orderBy('lastname', $sortDir)->orderBy('firstname');
				}
			}
			if ($groupped && $gid) $query->where('group_id', $gid);
			if ($q) $query->where('firstname', 'like', '%'.$q.'%')->orwhere('lastname', 'like', '%'.$q.'%');
			$page = $query->paginate(config('app.perpage'));
			$groups = Group::getPageGroups($page);
      return response()->json([
				'pages' => $page,
				'groups' => $groups
			]);
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
