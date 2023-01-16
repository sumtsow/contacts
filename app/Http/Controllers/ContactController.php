<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Type;
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
			$type = Type::findOrFail($request->type_id);
			$request->value = trim($request->value);
			$contact->value =  $request->value;
			if ($type->input_type === 'tel') {
				$contact->value =  preg_replace('#[^\+\d]#', '', $contact->value);
				if (!$contact->value) {
					return response()->json([ 'message' => 'Помилка даних!', 'errors' => ['value' => 'У полі Контакт допускаються лише символ "+" та цифри, наприклад, +380441112233'] ]);
				}
			}
      $contact->enabled = intval($request->enabled);
			$contact->save();
      return response()->json([ $contact ]);
    }
}
