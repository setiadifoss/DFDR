<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Traits\ApiResponser;
use App\Models\Degree;
use Illuminate\Http\Request;

use Auth;

/**
 *
 * @OA\Tag(
 *     name="Degree",
 *     description="API Endpoints of Projects"
 * )
*/
class DegreeController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/degree",
     *     tags={"Degree"},
     *     description="Degree",
     *     @OA\Response(response="default", description="Degree Index")
     * )
     */
    public function index()
    {
      // dd("die");
      $degree = Degree::orderBy('id', 'DESC')->get();
      return $this->success(['degree' => $degree]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/degree",
     *     tags={"Degree"},
     *     description="Add new",
     *     operationId="postDegree",
     *     @OA\RequestBody(
     *         description="Add new Degree",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Degree Name",
     *                     property="degree_name",
     *                     type="string"
     *                 ),
     *                 required={"degree_name"}
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
            'degree_name' => 'required',
        ]);
        $degree = New Degree;
        $degree->degree_name = $request->degree_name;
        $degree->created_by = Auth::User()->id;
        $degree->save();
        
        return $this->success(['degree' => $degree ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/degree/{id}",
     *     tags={"Degree"},
     *     description="View By Id",
     *     operationId="showDegree",
     *     @OA\Parameter(
     *         description="ID of Degree",
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
      $degree = Degree::find($id);
      return $this->success(['degree' => $degree]);
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
     *     path="/degree/{id}",
     *     tags={"Degree"},
     *     description="Update Data",
     *     operationId="putDegree",
     *     @OA\RequestBody(
     *         description="Add new Degree",
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="degree_name",
     *                     type="string"
     *                 ),
     *          )
     *     ),
     *     @OA\Parameter(
     *         description="ID of Degree",
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
        'degree_name' => 'required',
      ]);
      $degree = Degree::find($id);
      $degree->degree_name = $request->degree_name;
      $degree->updated_by = Auth::User()->id;
      $degree->save();
      
      return $this->success(['degree' => $degree]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *     path="/degree/{id}",
     *     tags={"Degree"},
     *     description="Delete Data",
     *     operationId="destroyDegree",
     *     @OA\Parameter(
     *         description="ID of Degree",
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
      $degree = Degree::destroy($id);
      return $this->success(['degree' => $degree]);
    }

     /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/degree/search/{name}",
     *     tags={"Degree"},
     *     description="Search Data",
     *     operationId="searchDegree",
     *     @OA\Parameter(
     *         description="Name of Degree",
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
      $degree = Degree::where('degree_name', 'like', '%'.$name.'%')->get();
      return $this->success(['degree' => $degree]);
    }
}
