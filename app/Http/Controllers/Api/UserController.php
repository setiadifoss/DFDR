<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Controllers\Controller;

use App\Traits\ApiResponser;
use App\Models\User;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Year;
use App\Models\UploadForm;
use Illuminate\Http\Request;

use App\Mail\VerifiedUserRegisteredMail;
use App\Mail\RejectedUserRegisteredMail;
use App\Mail\ResetPasswordToken;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

use App\Exports\TemplateExport;
use App\Exports\UsersExport;
use App\Exports\EditorExport;
use App\Imports\UsersImport;
use App\Imports\EditorImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

/**
 *
 * @OA\Tag(
 *     name="User",
 *     description="API Endpoints of Projects"
 * )
*/
class UserController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/user",
     *     tags={"User"},
     *     description="View All",
     *     operationId="findAllUser",
     *     @OA\Response(response="default", description="Success get data"),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function index()
    {
      // dd("die");
      $user = User::orderBy('id', 'DESC')->get();
      return $this->success(['user' => $user]);
    }

    /**
     * @OA\Get(
     *     path="/user/editor",
     *     tags={"User"},
     *     description="View All",
     *     operationId="findAllUserEditor",
     *     @OA\Response(response="default", description="Success get data"),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function userEditor()
    {
      $user = User::orderBy('id', 'DESC')
              ->where('role', '=', 'Editor')
              ->get();
      return $this->success(['user' => $user]);
    }


    /**
     * @OA\Get(
     *     path="/user/contribution",
     *     tags={"User"},
     *     description="View All",
     *     operationId="findAllUserContribution",
     *     @OA\Response(response="default", description="Success get data"),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function userDepositCont()
    {
      $user = User::orderBy('id', 'DESC')
              ->where('role', '=', 'User')
              ->where('approved', '=', '1')
              ->get();

      foreach ($user as $val) {
        $faculty = Faculty::find($val->faculty);
        $deposit = UploadForm::where('user_id', '=', $val->id)->count();

        $val->faculty_name = $faculty->faculty_name;
        $val->contribution = $deposit;
      }

      return $this->success(['user' => $user]);
    }

    /**
     * @OA\Get(
     *     path="/user/main",
     *     tags={"User"},
     *     description="View All",
     *     operationId="findAllUserMain",
     *     @OA\Response(response="default", description="Success get data"),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function userMain()
    {
      $user = User::orderBy('id', 'DESC')
              ->where('role', '=', 'User')
              ->get();
      return $this->success(['user' => $user]);
    }

    public function viewPDF()
    {
      $fileName = 'file.pdf';
      return $this->success(['name' => $fileName]);
    }
    
    /**
     * @OA\Post(
     *     path="/user/checkName",
     *     tags={"User"},
     *     description="check User by name",
     *     operationId="checkName",
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 )
     *          )
     *     ),
     *     @OA\Response(response="default", description="Success Input Data"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function checkName(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        if( User::where('name', '=', $request->name)->exists())
          return $this->error("data exist");
        else  
          return $this->success(null,"data new");
    }

    /**
     * @OA\Post(
     *     path="/user/checkEmail",
     *     tags={"User"},
     *     description="check User by email",
     *     operationId="checkEmail",
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 )
     *          )
     *     ),
     *     @OA\Response(response="default", description="Success Input Data"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        if( User::where('email', '=', $request->email)->exists())
          return $this->error("data exist");
        else  
          return $this->success(null,"data new");
    }

    /**
     * @OA\Post(
     *     path="/user/checkSpecific",
     *     tags={"User"},
     *     description="check User by Specific",
     *     operationId="checkSpecific",
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *              @OA\Property(
     *                     property="place_of_birth",
     *                     type="string"
     *                 ),
     *              @OA\Property(
     *                     property="date_of_birth",
     *                     type="string"
     *                 ),
     *              @OA\Property(
     *                     property="gender",
     *                     type="string"
     *                 )
     *          )
     *     ),
     *     @OA\Response(response="default", description="Success Check Data"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function checkSpecific(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'place_of_birth' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
        ]);
        
        $cName = User::where('name', '=', $request->name)->exists();
        $cPBirth = User::where('place_of_birth', '=', $request->place_of_birth)->exists();
        $cDBirth = User::where('date_of_birth', '=', $request->date_of_birth)->exists();
        $cGender = User::where('gender', '=', $request->gender)->exists();

        if($cName && $cPBirth && $cDBirth && $cGender)
          return $this->error("data exist");
        else  
          return $this->success(null,"data new");
    }

    /**
     * @OA\Post(
     *     path="/user/checkPass/{id}",
     *     tags={"User"},
     *     description="check User by Pass",
     *     operationId="checkPass",
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 )
     *          )
     *     ),
     *     @OA\Parameter(
     *         description="ID of User",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(response="default", description="Success Check Data"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function checkPass(Request $request, $id)
    {
      $request->validate([
        'password' => 'required|string'
      ]);
      
      $user = User::find($id);
      
      if(Hash::check($request->password, $user->password))
        return $this->success(null,"data exist");
      else
        return $this->error("data unexist");
    }

    /**
     * @OA\Post(
     *     path="/user/checkCode",
     *     tags={"User"},
     *     description="check User by Code",
     *     operationId="checkCode",
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *              @OA\Property(
     *                     property="code",
     *                     type="string"
     *                 )
     *          )
     *     ),
     *     @OA\Response(response="default", description="Success Input Data"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function checkCode(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'code' => 'required'
        ]);
        
        $getData = User::where('email', '=', $request->email)->get();

        if (Hash::check($request->code, $getData[0]->remember_token))
          return $this->success(null,"data exist");  
        else  
          return $this->error("data new");
          // return $this->success($getData[0]->remember_token);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'user' => 'required',
        // ]);
        $user = User::create($request->all());
        return $this->success(['user' => $user ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     /**
     * @OA\Get(
     *     path="/user/{id}",
     *     tags={"User"},
     *     description="View By Id",
     *     operationId="showUser",
     *     @OA\Parameter(
     *         description="ID of User",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(response="default", description="Success Input Data"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function show($id)
    {
        $user = User::find($id);
        return $this->success(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *     path="/user/verified/{id}",
     *     tags={"User"},
     *     description="verified User",
     *     operationId="putUser",
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="approved",
     *                     type="integer"
     *                 ),
     *              @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *              @OA\Property(
     *                     property="passwordRe",
     *                     type="string"
     *                 ),
     *          )
     *     ),
     *     @OA\Parameter(
     *         description="ID of User",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(response="default", description="Success Input Data"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        switch ($request->approved) {
          case 1:
            $randomString = Str::random(3);
            $newPass = uniqid("dGR").$randomString.date("yd");

            date_default_timezone_set('Asia/Jakarta');

            $user->approved = $request->approved;
            $user->email_verified_at = date("Y-m-d h:i:s");
            
            if ($request->password != '' || $request->passwordRe != '')  // true
            { $user->password = bcrypt($request->passwordRe);}
            else
            { $user->password = bcrypt($newPass);}

            $user->save();

            $details = [
              'title' => $user->name,
              'body' => "Password : ".$newPass,
              'link' => url("")
            ];

            // Send Mail
            if ($request->password == '' || $request->passwordRe == '')  // true
            { Mail::to($user->email)->send(new VerifiedUserRegisteredMail($details)); }
            break;

          case 2:
            $user->approved = $request->approved;
            $user->save();

            $details = [
              'title' => $user->name
            ];

            // Send Mail
            Mail::to($user->email)->send(new RejectedUserRegisteredMail($details));
            break;
        }

        return $this->success(null, "data success");
    }


    /**
     * @OA\Post(
     *     path="/user/updateData/{id}",
     *     tags={"User"},
     *     description="updateData User",
     *     operationId="postUpdateUser",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name","email","phone", "address"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
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
     *     @OA\Parameter(
     *         description="ID of User",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(response="default", description="Success Input Data"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function updateData(Request $request, $id)
    {
      $request->validate([
          'name' => 'required',
          'email' => 'required',
          'phone' => 'required',
          'address' => 'required',
      ]);

      $user = User::find($id);
      $user->name = $request->name;
      $user->email = $request->email;
      $user->phone = $request->phone;
      $user->address = $request->address;
      $user->save();
      // $user->update($request->all());
      
      if ($request->file('upload_card') != "")
      {
        if ($upload_card = $request->file('upload_card')) {
          $path = public_path() . '/storage/uploads/upload_card';
          $upload_card->move($path, $upload_card->getClientOriginalName());
        }
  
        $user->upload_card = url('/').'/show-image/upload_card/'.$upload_card->getClientOriginalName();
        $user->upload_card_name = $upload_card->getClientOriginalName();
        $user->save();
      }

      return $this->success(['user' => $user]);
    }


    /**
     * @OA\Post(
     *     path="/user/updateDataFull/{id}",
     *     tags={"User"},
     *     description="updateData User",
     *     operationId="postUpdateUserFull",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={
     *                      "name","phone","email","date_of_birth",
     *                      "place_of_birth","department","faculty","gender",
     *                      "year","address"
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
     *                     property="year",
     *                     type="integer",
     *                     format="int64",
     *                     example=0
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
     *     @OA\Parameter(
     *         description="ID of User",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(response="default", description="Success Input Data"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function updateDataFull(Request $request, $id) 
    {
      $request->validate([
          "name" => 'required',
          "phone" => 'required',
          "email" => 'required',
          "date_of_birth" => 'required',
          "place_of_birth" => 'required',
          "department" => 'required',
          "faculty" => 'required',
          "gender" => 'required',
          "year" => 'required',
          "address" => 'required',
      ]);

      $user = User::find($id);
      $y = $user->password;
      $newPassword = $request->password;
      $newRePassword = $request->passwordRe;

      $user->name = $request->name;
      $user->phone = $request->phone;
      $user->email = $request->email;
      $user->date_of_birth = $request->date_of_birth;
      $user->place_of_birth = $request->place_of_birth;
      $user->department = $request->department;
      $user->faculty = $request->faculty;
      $user->gender = $request->gender;
      $user->years = $request->year;
      $user->address = $request->address;
      $user->save();
      
      if ($request->file('upload_card') != "")
      {
        if ($upload_card = $request->file('upload_card')) {
          $path = public_path() . '/storage/uploads/upload_card';
          $upload_card->move($path, $upload_card->getClientOriginalName());
        }

        $user->upload_card = url('/').'/show-image/upload_card/'.$upload_card->getClientOriginalName();
        $user->upload_card_name = $upload_card->getClientOriginalName();
        $user->save();
      }

      if (($newPassword != 'undefined' || $newRePassword != 'undefined')
      && ($newPassword != '' || $newRePassword != '')
      && ($newPassword != null || $newRePassword != null)
      && ($newPassword == $newRePassword))  // true
      {
        $user->password = bcrypt($request->passwordRe);
        $user->save();
      }
      else
      {
        $user->password = $y;
        $user->save();
      }
      
      return $this->success(['user' => $user]);
    }

    /**
     * @OA\Post(
     *     path="/user/changePass/{id}",
     *     tags={"User"},
     *     description="change User Pass",
     *     operationId="changePass",
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *              @OA\Property(
     *                     property="newPass",
     *                     type="string"
     *                 )
     *          )
     *     ),
     *     @OA\Parameter(
     *         description="ID of User",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(response="default", description="Success Check Data"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function changePass(Request $request, $id)
    {
      $request->validate([
        'password' => 'required|string',
        'newPass' => 'required|string'
      ]);
      
      $user = User::find($id);
      
      if(Hash::check($request->password, $user->password))
      {
        $user->password = bcrypt($request->newPass);
        $user->save();

        return $this->success(null, "data exist");
      }
      else
        return $this->error("data unexist");
    }

    /**
     * @OA\Post(
     *     path="/user/reqResetPass",
     *     tags={"User"},
     *     description="Request Reset Password",
     *     operationId="reqResetPass",
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 )
     *          )
     *     ),
     *     @OA\Response(response="default", description="Success Check Data"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function reqResetPass(Request $request)
    {
      $request->validate([
        'email' => 'required',
      ]);
        
      $getData = User::where('email', '=', $request->email)->get();
      
      $randomString = Str::random(5);
      $resToken = uniqid("dGRRP").$randomString;

      $user = User::find($getData[0]->id);
      $user->remember_token = bcrypt($resToken);
      $user->save();
      
      $details = [
        'title' => $user->name,
        'body' => "Reset Code : ".$resToken,
        'link' => url("")
      ];

      // Send Mail
      Mail::to($user->email)->send(new ResetPasswordToken($details)); 

      return $this->success($resToken);
    }

    /**
     * @OA\Post(
     *     path="/user/resetPass",
     *     tags={"User"},
     *     description="Reset Password",
     *     operationId="resetPass",
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *              @OA\Property(
     *                     property="code",
     *                     type="string"
     *                 ),
     *              @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *              @OA\Property(
     *                     property="newPass",
     *                     type="string"
     *                 )
     *          )
     *     ),
     *     @OA\Response(response="default", description="Success Check Data"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
    public function resetPass(Request $request)
    {
      $request->validate([
        'email' => 'required',
        'code' => 'required',
        'password' => 'required|string',
        'newPass' => 'required|string',
      ]);

      $getData = User::where('email', '=', $request->email)->get();
      $user = User::find($getData[0]->id);
      
      if (Hash::check($request->code, $getData[0]->remember_token))
      {
        $user->password = bcrypt($request->newPass);
        $user->remember_token = null;
        $user->save();

        return $this->success(null, "data exist");
      }
      else
        return $this->error("data unexist");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *     path="/user/{id}",
     *     tags={"User"},
     *     description="Delete Data",
     *     operationId="destroyUser",
     *     @OA\Parameter(
     *         description="ID of User",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(response="default", description="Success Delete Data"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *    security={{"bearerAuth":{}}}, 
     * )
     */
    public function destroy($id)
    {
      $user = User::destroy($id);
      return $this->success(['user' => $user]);
    }

    public function export() 
    {
        // $now = date('Y-m-d');
        $fileName = 'User_Release.xlsx';
        File::delete('downloads/release/'.$fileName);

        $user = User::where('role', '=', 'User')->get();

        foreach ($user as $key) 
        {
          $faculty_name = Faculty::find($key->faculty);
          $key->faculty_name = $faculty_name->faculty_name;

          $department_name = Department::find($key->department);
          $key->department_name = $department_name->department_name;

          $year = Year::find($key->years);
          $key->years = $year->year;

          // $key->status = ucfirst($key->status);
          // $key->division_name = $key->uploadFormDivision[0]->division;
        }

        $data = ['user' => $user];

        $userexcel = Excel::store(new UsersExport($data), 'downloads/release/'.$fileName, 'real_public');
        return $this->success(['excel' => $fileName]);
    }

    public function exportEditor() 
    {
        $fileName = 'Editor_Release.xlsx';
        File::delete('downloads/release/'.$fileName);

        // get data..
        $user = User::where('role', '=', 'Editor')->get();
        $data = ['user' => $user];

        $userexcel = Excel::store(new EditorExport($data), 'downloads/release/'.$fileName, 'real_public');
        return $this->success(['excel' => $fileName]);
    }

    public function exportTemplate() 
    {
        $fileName = 'template_user.xlsx';
        return $this->success(['excel' => $fileName]);
    }

    public function exportExcel() 
    {
        dd("test");
    }

    public function import() 
    {
        $is_success = Excel::import(new UsersImport,request()->file('file'));
             
        return $is_success ? response()->json(['success' => true]) : response()->json(['success' => false]);
    }

    public function importEditor() 
    {
        Excel::import(new EditorImport,request()->file('file'));
             
        return back();
    }

     /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
}
