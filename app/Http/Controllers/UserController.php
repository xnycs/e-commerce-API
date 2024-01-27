<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Models\RegisterSkill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function login(Request $request) {
        
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            $user['token'] = $user->createToken('MyAppToken')->plainTextToken;
            return response()->json(['user' => $user, 'message' => 'Login successful']);
        }

        // Authentication failed...
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function register(Request $request) {
        /*
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:6',
        ]);

        try {
            DB::beginTransaction();

            // You can customize this logic based on your requirements
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);

            // Commit the transaction if the user creation is successful
            DB::commit();

            return response()->json([
                'message' => 'User created successfully!',
                'user' => $user,
            ], 201); // 201 Created status code

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => 'Failed to create user.',
                'message' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status code
        }
        */

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:registers|max:255',
            'skills' => 'required'
        ]);

        // return $validatedData;
        try {
            DB::beginTransaction();

            // query builder
            DB::table('registers')->insert([
                'name' => $validatedData['name'],
                'email' => $validatedData['email']
            ]);

            $register = Register::where('email', $validatedData['email'])->first();

            // ->where('title', 'Example')->delete();

            $skills = [1,4,5];

            DB::table('register_skills')->where('register_id', $register->id)->delete();

            foreach ($skills as $skill) {

                DB::table('register_skills')->insert([
                    'register_id' => $register->id,
                    'skill_id' => $skill
                ]);
            }
         
            DB::commit();

            return response()->json([
                'message' => 'Registration successfully!',
            ], 201); // 201 Created status code

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => 'Registration failed.',
                'message' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status code
        }

    }

    public function checkToken() {
        
        return auth()->user();
    }
}
