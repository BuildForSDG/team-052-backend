<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\RespondsWithJson;
use App\Http\Controllers\Utils\SimplePaginates;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use RespondsWithJson, SimplePaginates;

    /**
     * Store a new admin user to the database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request)
    {
        if (! $request->user()->isSuperAdmin()) {
            abort(403, 'You dont not have the permission to create an admin');
        }

        $data = $this->validate($request, $this->creationRules());
        $password = Hash::make($data['password']);

        $admin = new User;
        $admin->name = $data['name'];
        $admin->email = $data['email'];
        $admin->password = $password;
        $admin->admin_role = $data['admin_role'] ?? 'responder';

        $admin->save();

        return $this->storeResponse($admin);
    }

    /**
     * Validation rules on creation
     *
     * @return array
     */
    protected function creationRules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
            'admin_role' => ['nullable', Rule::in(['superadmin', 'responder'])]
        ];
    }
}
