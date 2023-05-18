<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Traits\ApiResponser;
use App\Models\Year;
use Illuminate\Http\Request;

use Auth;

/**
 *
 * @OA\Tag(
 *     name="Year",
 *     description="API Endpoints of Projects"
 * )
*/
class YearController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/year",
     *     tags={"Year"},
     *     description="View All",
     *     operationId="findAllYear",
     *     @OA\Response(response="default", description="Success get data")
     * )
     */
    public function index()
    {
      // dd("die");
      $year = Year::orderBy('id', 'DESC')->get();
      return $this->success(['year' => $year]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/year",
     *     tags={"Year"},
     *     description="Add new",
     *     operationId="postYear",
     *     @OA\RequestBody(
     *         description="Add new Year",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Year",
     *                     property="year",
     *                     type="string"
     *                 ),
     *                 required={"year"}
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
            'year' => 'required',
        ]);

        if( Year::where('year', '=', $request->year)->exists())
        {  
          return $this->error("data already exist");
        }
        else 
        {
          $year = New Year;
          $year->year = $request->year;
          $year->created_by = Auth::User()->id;
          $year->save();

          return $this->success(['year' => $year ]);
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
     *     path="/year/{id}",
     *     tags={"Year"},
     *     description="View By Id",
     *     operationId="showYear",
     *     @OA\Parameter(
     *         description="ID of Year",
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
        $year = Year::find($id);
        return $this->success(['year' => $year]);
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
     *     path="/year/{id}",
     *     tags={"Year"},
     *     description="Update Data",
     *     operationId="putYear",
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="year",
     *                     type="string"
     *                 ),
     *          )
     *     ),
     *     @OA\Parameter(
     *         description="ID of Year",
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
            'year' => 'required',
        ]);
        if( Year::where('year', '=', $request->year)->exists())
        {  
          return $this->error("data already exist");
        }
        else 
        {
          $year = Year::find($id);
          $year->year = $request->year;
          $year->created_by = Auth::User()->id;
          $year->save();
          
          return $this->success(['year' => $year]);
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
     *     path="/year/{id}",
     *     tags={"Year"},
     *     description="Delete Data",
     *     operationId="destroyYear",
     *     @OA\Parameter(
     *         description="ID of Year",
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
      $year = Year::destroy($id);
      return $this->success(['year' => $year]);
    }

     /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/year/search/{name}",
     *     tags={"Year"},
     *     description="Search Data",
     *     operationId="searchYear",
     *     @OA\Parameter(
     *         description="Name of Year",
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
      $year = Year::where('year', 'like', '%'.$name.'%')->get();
      return $this->success(['year' => $year]);
    }
}
