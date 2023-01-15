<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Http\Requests\StoreTypeRequest;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return response()->json(Type::all());
    }

    /**
     * Return enum options for input_type field.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return response()->json(Type::getInputTypes());
    }

    /**
     * Update existing or store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTypeRequest $request, int $id)
    {
      if ($id) {
        $type = Type::findOrFail($id);
      } else {
        $type = new Type();
      }
      $type->title = $request->title;
      $type->enabled = intval($request->enabled);
			$type->input_type = $request->input_type;
			$type->save();
      return response()->json([ $type ]);
    }
}
