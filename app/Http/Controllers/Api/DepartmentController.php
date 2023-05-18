<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Traits\ApiResponser;
use App\Models\Department;
use Illuminate\Http\Request;

use Auth;

/**
 *
 * @OA\Tag(
 *     name="Department",
 *     description="API Endpoints of Projects"
 * )
*/
class DepartmentController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/department",
     *     tags={"Department"},
     *     description="View All",
     *     operationId="findAllDepartment",
     *     @OA\Response(response="default", description="Success get data")
     * )
     */
    public function index()
    {
      // dd("die");
      $department = Department::orderBy('id', 'DESC')->get();
      return $this->success(['department' => $department]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/department",
     *     tags={"Department"},
     *     description="Add new",
     *     operationId="postDepartment",
     *     @OA\RequestBody(
     *         description="Add new Department",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Department Name",
     *                     property="department_name",
     *                     type="string"
     *                 ),
     *                 required={"department_name"}
     *             )
     *         )
     *     ),
     *     @OA\Response(response="default", description="Success Input Data"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *    security={{"bearerAuth":{}}}, 
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required',
        ]);

        if( Department::where('department_name', '=', $request->department_name)->exists())
        {  
          return $this->error("data already exist");
        }
        else 
        {
          $department = New Department;
          $department->department_name = $request->department_name;
          $department->created_by = Auth::User()->id;
          $department->save();

          return $this->success(['department' => $department ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/department/{id}",
     *     tags={"Department"},
     *     description="View By Id",
     *     operationId="showDepartment",
     *     @OA\Parameter(
     *         description="ID of Department",
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
     *     )
     * )
     */
    public function show($id)
    {
      $department = Department::find($id);
      return $this->success(['department' => $department]);
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
     *     path="/department/{id}",
     *     tags={"Department"},
     *     description="Update Data",
     *     operationId="putDepartment",
     *     @OA\RequestBody(
     *         description="Add new Department",
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="department_name",
     *                     type="string"
     *                 ),
     *          )
     *     ),
     *     @OA\Parameter(
     *         description="ID of Department",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(response="default", description="Success Update Data"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     *    security={{"bearerAuth":{}}}, 
     * )
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'department_name' => 'required',
      ]);

      if( Department::where('department_name', '=', $request->department_name)->exists())
        {  
          return $this->error("data ready exist");
        }
        else 
        {
          $department = Department::find($id);
          $department->department_name = $request->department_name;
          $department->updated_by = Auth::User()->id;
          $department->save();

          return $this->success(['department' => $department]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *     path="/department/{id}",
     *     tags={"Department"},
     *     description="Delete Data",
     *     operationId="destroyDepartment",
     *     @OA\Parameter(
     *         description="ID of Department",
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
      $department = Department::destroy($id);
      return $this->success(['department' => $department]);
    }

     /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/department/search/{name}",
     *     tags={"Department"},
     *     description="Search Data",
     *     operationId="searchDepartment",
     *     @OA\Parameter(
     *         description="Name of Department",
     *         in="path",
     *         name="name",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="string"
     *         ),
     *     ),
     *     @OA\Response(response="default", description="Success Search Data"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid Parameter",
     *     ),
     * )
     */
    public function search($name)
    {
      $department = Department::where('department_name', 'like', '%'.$name.'%')->get();
      return $this->success(['department' => $department]);
    }
}
