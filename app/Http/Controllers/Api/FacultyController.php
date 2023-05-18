<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Traits\ApiResponser;
use App\Models\Faculty;
use Illuminate\Http\Request;

use Auth;

/**
 *
 * @OA\Tag(
 *     name="Faculty",
 *     description="API Endpoints of Projects"
 * )
*/
class FacultyController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/faculty",
     *     tags={"Faculty"},
     *     description="View All",
     *     operationId="findAllFaculty",
     *     @OA\Response(response="default", description="Success get data")
     * )
     */
    public function index()
    {
      $faculty = Faculty::orderBy('id', 'DESC')->get();
      return $this->success(['Faculty' => $faculty]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/faculty",
     *     tags={"Faculty"},
     *     description="Add new",
     *     operationId="postFaculty",
     *     @OA\RequestBody(
     *         description="Add new Faculty",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Faculty Name",
     *                     property="faculty_name",
     *                     type="string"
     *                 ),
     *                 required={"faculty_name"}
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
            'faculty_name' => 'required',
        ]);

        if( Faculty::where('faculty_name', '=', $request->faculty_name)->exists())
        {  
          return $this->error("data ready exist");
        }
        else 
        {
          $faculty = New Faculty;
          $faculty->faculty_name = $request->faculty_name;
          $faculty->created_by = Auth::User()->id;
          $faculty->save();

          return $this->success(['Faculty' => $faculty ]);
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
     *     path="/faculty/{id}",
     *     tags={"Faculty"},
     *     description="View By Id",
     *     operationId="showFaculty",
     *     @OA\Parameter(
     *         description="ID of Faculty",
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
        $faculty = Faculty::find($id);
        return $this->success(['Faculty' => $faculty]);
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
     *     path="/faculty/{id}",
     *     tags={"Faculty"},
     *     description="Update Data",
     *     operationId="putFaculty",
     *     @OA\RequestBody(
     *         description="Add new Faculty",
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="faculty_name",
     *                     type="string"
     *                 ),
     *          )
     *     ),
     *     @OA\Parameter(
     *         description="ID of Faculty",
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
            'faculty_name' => 'required',
        ]);

        if( Faculty::where('faculty_name', '=', $request->faculty_name)->exists())
        {  
          return $this->error("data ready exist");
        }
        else 
        {
          $faculty = Faculty::find($id);
          $faculty->faculty_name = $request->faculty_name;
          $faculty->updated_by = Auth::User()->id;
          $faculty->save();
          
          return $this->success(['Faculty' => $faculty]);
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
     *     path="/faculty/{id}",
     *     tags={"Faculty"},
     *     description="Delete Data",
     *     operationId="destroyFaculty",
     *     @OA\Parameter(
     *         description="ID of Faculty",
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
      $faculty = Faculty::destroy($id);
      return $this->success(['Faculty' => $faculty]);
    }

     /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/faculty/search/{name}",
     *     tags={"Faculty"},
     *     description="Search Data",
     *     operationId="searchFaculty",
     *     @OA\Parameter(
     *         description="Name of Faculty",
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
      $faculty = Faculty::where('faculty_name', 'like', '%'.$name.'%')->get();
      return $this->success(['Faculty' => $faculty]);
    }
}
