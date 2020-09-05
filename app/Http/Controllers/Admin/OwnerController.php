<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Show all user owner
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::whereType('owner')->paginate(15);

        return response()->json($users);
    }

    /**
     * Show user type owner by given id
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $owner = User::whereType('owner')->findOrFail($id);

        return response()->json($owner);
    }

    /**
     * Update user type owner
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        $owner = User::whereType('owner')->findOrFail($id);

        $owner->fill($data);
        $owner->save();

        return response()->json(['flash' => 'Owner successfully updated'], 201);
    }
}
