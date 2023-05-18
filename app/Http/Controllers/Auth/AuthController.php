<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\ApiCode;
use App\Models\User;
use App\Models\NotifyUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Password;

use App\Traits\ApiResponser;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

use App\Mail\VerifiedUserRegisteredMail;
use App\Mail\RegisteredUserMail;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Seeder;

/**
 * @OA\SecurityScheme(
*      securityScheme="bearerAuth",
*      in="header",
*      name="bearerAuth",
*      type="http",
*      scheme="bearer",
*      bearerFormat="JWT",
* ),
 * @OA\Tag(
 *     name="Auth",
 *     description="Auth endpoints",
 * )
 */
class AuthController extends Controller
{
  use ApiResponser;

  /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Auth"},
     *     description="Register API",
     *     operationId="register",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={
     *                      "name","phone","email","date_of_birth",
     *                      "place_of_birth","department","faculty","gender",
     *                      "years","address", "upload_card", "created_from",
     *                      "role"
     *                 },
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="date_of_birth",
     *                     type="string",
     *                     example="1990-01-01"
     *                 ),
     *                 @OA\Property(
     *                     property="place_of_birth",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="department",
     *                     type="integer",
     *                     format="int64",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="faculty",
     *                     type="integer",
     *                     format="int64",
     *                     example=0
     *                 ),
     *                 @OA\Property(
     *                     property="gender",
     *                     type="string",
     *                     example="L"
     *                 ),
     *                 @OA\Property(
     *                     property="years",
     *                     type="integer",
     *                     format="int64",
     *                     example=0
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="role",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="created_from",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="passwordRe",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="upload_card",
     *                     type="string",
     *                     format="binary",
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="default", description="Success Input Data"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function register(Request $request) {
        // dd($request->all());
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            // 'password' => 'required|string|confirmed',
            'phone' => 'required',
            'place_of_birth' => 'required',
            'date_of_birth' => 'required',
            'department' => 'required',
            'faculty' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'years' => 'required',
            'role' => 'required',
            'upload_card' => 'required|mimes:png,jpg|max:2048',
            'created_from' => 'required',
        ]);

        
        if ($upload_card = $request->file('upload_card')) {

          $path = public_path() . '/storage/uploads/upload_card';
          $upload_card->move($path, $upload_card->getClientOriginalName());
        }

        $randomString = Str::random(3);
        $newPass = uniqid("dGR").$randomString.date("yd");

        $user = new User();
          $user->name = $fields['name'];
          $user->email = $fields['email'];
          $user->phone = $fields['phone'];
          $user->place_of_birth = $fields['place_of_birth'];
          $user->date_of_birth = $fields['date_of_birth'];
          $user->department = $fields['department'];
          $user->faculty = $fields['faculty'];
          $user->gender = $fields['gender'];
          $user->address = $fields['address'];
          $user->years = $fields['years'];

          if($fields['created_from'] == 'Dashboard')
          { $user->approved = 1; }

          $user->upload_card = url('/').'/show-image/upload_card/'.$upload_card->getClientOriginalName();
          $user->upload_card_name = $upload_card->getClientOriginalName();
          $user->photo = "-";
          $user->role = $fields['role'];
          $user->password = bcrypt($newPass);

          if ($request->password != 'undefined' || 
              $request->passwordRe != 'undefined' ||
              $request->password != '' || 
              $request->passwordRe != '')  // true
            $user->password = bcrypt($request->passwordRe);

          $user->save();

          $token = $user->createToken('myapptoken')->plainTextToken;

          $notif_user = new NotifyUser;
          $notif_user->message = 'new user with email ' . $user->email;
          $notif_user->user_id = $user->id;
          $notif_user->save();
          
          if($fields['created_from'] == 'Dashboard')
          {
            // approved
            $details = [
              'title' => $user->name,
              'body' => "Password : ".$newPass,
              'link' => url("")
            ];

            if ($request->password == 'undefined' || 
                $request->passwordRe == 'undefined' ||
                $request->password == '' || 
                $request->passwordRe == '')  // true
              Mail::to($user->email)->send(new VerifiedUserRegisteredMail($details));
          }
          else
          {
            // pending
            $details = [
              'title' => $user->name
            ];

            Mail::to($user->email)->send(new RegisteredUserMail($details));
          }

          return $this->success(['user' => $user , 'token' => $token]);
    }

    /**
     * @OA\Post(
     *     path="/registerAdmin",
     *     tags={"Auth"},
     *     description="Register Admin API",
     *     operationId="registerAdmin",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={
     *                      "name","phone","email","date_of_birth",
     *                      "place_of_birth","gender",
     *                      "address", "upload_card", 
     *                      "password"
     *                 },
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="date_of_birth",
     *                     type="string",
     *                     example="1990-01-01"
     *                 ),
     *                 @OA\Property(
     *                     property="place_of_birth",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="gender",
     *                     type="string",
     *                     example="L"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="upload_card",
     *                     type="string",
     *                     format="binary",
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="default", description="Success Input Data"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function registerAdmin(Request $request) {
        
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required',
            'phone' => 'required',
            'place_of_birth' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'upload_card' => 'required|mimes:png,jpg|max:2048',
        ]);
        
        if ($upload_card = $request->file('upload_card')) {
          $path = public_path() . '/storage/uploads/upload_card';
          $upload_card->move($path, $upload_card->getClientOriginalName());
        }

        $user = new User();
        $user->name = $fields['name'];
        $user->email = $fields['email'];
        $user->phone = $fields['phone'];
        $user->place_of_birth = $fields['place_of_birth'];
        $user->date_of_birth = $fields['date_of_birth'];
        $user->department = '1';
        $user->faculty = '0';
        $user->gender = $fields['gender'];
        $user->address = $fields['address'];
        $user->years = '0';
        $user->approved = 1;
        $user->upload_card = url('/').'/show-image/upload_card/'.$upload_card->getClientOriginalName();
        $user->upload_card_name = $upload_card->getClientOriginalName();
        $user->photo = "-";
        $user->role = "Admin";
        $user->password = bcrypt($fields['password']);
        $user->save();

          /*
          $token = $user->createToken('myapptoken')->plainTextToken;

          $notif_user = new NotifyUser;
          $notif_user->message = 'new user with email ' . $user->email;
          $notif_user->user_id = $user->id;
          $notif_user->save();
          
          if($fields['created_from'] == 'Dashboard')
          {
            // approved
            $details = [
              'title' => $user->name,
              'body' => "Password : ".$newPass,
              'link' => url("")
            ];

            Mail::to($user->email)->send(new VerifiedUserRegisteredMail($details));
          }
          else
          {
            // pending
            $details = [
              'title' => $user->name
            ];

            Mail::to($user->email)->send(new RegisteredUserMail($details));
          }*/

        return $this->success(['user' => $fields]);
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Auth"},
     *     description="login API",
     *     operationId="postAuth",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Email/Username",
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     description="Password",
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 required={"email","password"}
     *             )
     *         )
     *     ),
     *     @OA\Response(response="default", description="Success Input Data"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     )
     * )
     */
    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        
        // Check email
        $user = User::where('email', $fields['email'])->first();
        if($user->approved == 0){
          return response([
            'status' => 'false',
            'message' => 'Your account need confirmation from admin'
          ], 200);
        }
        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
              'status' => 'false',
                'message' => 'Login Fail, please check email or password must valid'
            ], 200);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        return $this->success(['user' => $user , 'token' => $token]);
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     tags={"Auth"},
     *     description="Auth",
     *     @OA\Response(response="default", description="preAdmin Index"),
     *     security={{"bearerAuth":{}}}, 
     * ),
     */
    public function logout() {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    /**
     * @OA\Get(
     *     path="/preAdmin",
     *     tags={"Auth"},
     *     description="Auth",
     *     @OA\Response(response="default", description="preAdmin Index")
     * )
     */
    public function preAdmin() {
      
      $user = User::get()->count();
      return $this->success(['data' => $user]);
    }

  //   public function forgotPassword(Request $request)
  //   {
  //     // dd(env('MAIL_HOST'));
  //     // $fields = $request->validate([
  //     //   'email' => 'required|string',
  //     // ]);
      
  //     $credentials = request()->validate(['email' => 'required|email']);
  //     $test = Password::sendResetLink($credentials);
      
  //     dd($test);

  //     return response()->json(["msg" => 'Reset password link sent on your email id.']);

  //   }

  //   public function reset(ResetPasswordRequest $request) {
  //     $reset_password_status = Password::reset($request->validated(), function ($user, $password) {
  //         $user->password = $password;
  //         $user->save();
  //     });

  //     if ($reset_password_status == Password::INVALID_TOKEN) {
  //         return $this->success(ApiCode::INVALID_RESET_PASSWORD_TOKEN);
  //     }

  //     return $this->success("Password has been successfully changed");
  // }
}
