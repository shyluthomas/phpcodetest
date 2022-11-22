<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Credentials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
        //validate the perams
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|unique:users,email|max:100',
            'profile_image' => '',
            'sex' => 'required',
            'username' => 'required|unique:user_credentails,username|max:50',
            'password' => 'required|max:50'
        ]);
        
        //Validation fails respond with 400 Bad request
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()])->setStatusCode(400);
        }

        try {
            
            //Store the uploaded profile image
            $fileContent = $request->profile_image;
            $ext = $fileContent->getClientOriginalExtension();
            $newFilename = "user_profile_image_" . now()->timestamp . "." . $ext;

            Storage::disk('local')->put(env('PROFILE_IMAGE_PATH') . $newFilename, $fileContent);
            
            //Store User Table data
            $user = new Users();
            $sex = strtolower($request->input('sex')) === 'male' ? 1 : 2;

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->profile_image = $newFilename; //Store image name in DB
            $user->sex = $sex;
            $user->save();

            //Store Credentials
            $credentials = new Credentials();
            $credentials->username = $request->input('username');
            $credentials->password = Hash::make($request->input('password'));
            $credentials->status = 1;
            
            //Users model has One to One directly save the credentials for
            //Newly created user
            Users::find($user->id)->credentials()->save($credentials);

            $content = array(
                'success' => true,
                'name' => $user->name,
                'id' => $user->id
            );

            return response()->json($content);
            
        } catch (\Exception $e) {
            $content = array(
                'success' => false,
                'data' => 'something went wrong.',
                'message' => 'There was an error while processing your request: ' .
                $e->getMessage()
            );
            return response()->json($content)->setStatusCode(500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function show(Users $users) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function edit(Users $users) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Users $users) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function destroy(Users $users) {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {
        
        //Validata input params
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:50',
            'password' => 'required|max:50'
        ]);
        
        //Validation fails respond with 400 Bad request
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()])->setStatusCode(400);
        }
        
        //Get user based on the username
        $user = Credentials::where('username', $request->username)->first();
        
        //if user exists
        if ($user) {
            //Verify the pasword hashes
            if (Hash::check($request->password, $user->password)) {
                //Password matched respond with success
                $content = array(
                    'success' => true,
                    'id' => $user->userid
                );

                return response()->json($content);
            }
        }
        
        //Invalid Login resopnd with 401 unAuthorized
        $content = array(
            'success' => false,
            'message' => 'Invalid Credentials'
        );
        return response()->json($content)->setStatusCode(401);
    }

}
