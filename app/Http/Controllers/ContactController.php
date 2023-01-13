<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return response()->json(Contact::where('user_id', Auth::id())->with('type')->get());
    }

    /**
     * Update existing or store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request, int $id)
    {
      if ($id) {
        $contact = Contact::findOrFail($id);
      } else {
        $contact = new Contact();
				$contact->user_id = Auth::id();
      }
			$contact->subscriber_id = $request->subscriber_id;
      $contact->type_id = $request->type_id;
			$contact->value = $request->value;
      $contact->enabled = intval($request->enabled);
			$contact->save();
      return response()->json([ $contact ]);
    }
}
