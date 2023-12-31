<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::selectRaw("TO_CHAR(created_at AT TIME ZONE 'America/La_Paz' AT TIME ZONE 'America/La_Paz', 'YYYY-MM-DD HH24:MI') AS fecha_formateada,*")->get();
        return $this->sendResponse($users, "lista de usuarios.");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        $user = User::create($request->all());
        return $this->sendResponse($user, "Usuario creado exitosamente.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return $this->sendResponse($user, "Usuario encontrado exitosamente.");
        } catch (\Throwable $th) {
            return $this->sendError("Usuario no encontrado.", 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'String'
        ]);
        try {
            $user = User::findOrFail($id);
            if (isset($request->password)) {
                $p = $request->password;
                return "ingresano null";
            } else {
                $p = $user->password;
            }
            $user->update(['name' => $request->name, 'email' => $request->email, 'password' => $p]);
            return $this->sendResponse($user, "Usuario actualizado correctamente.");
        } catch (\Throwable $th) {
            return $this->sendError("Usuario no encontrado.", 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return $this->sendResponse($user, "Usuario encontrado exitosamente.");
        } catch (\Throwable $th) {
            return $this->sendError("Usuario no encontrado.", 404);
        }
    }
}
