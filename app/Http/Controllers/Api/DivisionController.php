<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Traits\ApiResponser;
use App\Models\Division;
use Illuminate\Http\Request;

use Auth;

/**
 *
 * @OA\Tag(
 *     name="Division",
 *     description="API Endpoints of Projects"
 * )
*/
class DivisionController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/division",
     *     tags={"Division"},
     *     description="View All",
     *     operationId="findAllDivision",
     *     @OA\Response(response="default", description="Success get data")
     * )
     */
    public function index()
    {
      $division = Division::orderBy('id', 'DESC')->get();
      return $this->success(['division' => $division]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     /**
     * @OA\Post(
     *     path="/division",
     *     tags={"Division"},
     *     description="Add new",
     *     operationId="postDivision",
     *     @OA\RequestBody(
     *         description="Add new Division",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Division Name",
     *                     property="division_name",
     *                     type="string"
     *                 ),
     *                 required={"division_name"}
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
            'division_name' => 'required',
        ]);

        if( Division::where('division_name', '=', $request->division_name)->exists())
        {  
          return $this->error("data already exist");
        }
        else 
        {
          $division = New Division;
          $division->division_name = $request->division_name;
          $division->created_by = Auth::User()->id;
          $division->save();
          
          return $this->success(['division' => $division ]);
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
     *     path="/division/{id}",
     *     tags={"Division"},
     *     description="View By Id",
     *     operationId="showDivision",
     *     @OA\Parameter(
     *         description="ID of Division",
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
        $division = Division::find($id);
        
        return $this->success(['division' => $division]);
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
     *     path="/division/{id}",
     *     tags={"Division"},
     *     description="Update Data",
     *     operationId="putDivision",
     *     @OA\RequestBody(
     *         description="Add new Division",
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="division_name",
     *                     type="string"
     *                 ),
     *          )
     *     ),
     *     @OA\Parameter(
     *         description="ID of Division",
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
          'division_name' => 'required',
        ]);

        if( Division::where('division_name', '=', $request->division_name)->exists())
        {  
          return $this->error("data already exist");
        }
        else 
        {
          $division = Division::find($id);
          $division->division_name = $request->division_name;
          $division->updated_by = Auth::User()->id;
          $division->save();
          
          return $this->success(['division' => $division]);
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
     *     path="/division/{id}",
     *     tags={"Division"},
     *     description="Delete Data",
     *     operationId="destroyDivision",
     *     @OA\Parameter(
     *         description="ID of Division",
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
      $division = Division::destroy($id);
      return $this->success(['division' => $division]);
    }

     /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/division/search/{name}",
     *     tags={"Division"},
     *     description="Search Data",
     *     operationId="searchDivision",
     *     @OA\Parameter(
     *         description="Name of Division",
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
      $division = Division::where('division_name', 'like', '%'.$name.'%')->get();
      return $this->success(['division' => $division]);
    }
}
