<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Traits\ApiResponser;
use App\Models\Subject;
use Illuminate\Http\Request;

use Auth;

/**
 *
 * @OA\Tag(
 *     name="Subject",
 *     description="API Endpoints of Projects"
 * )
*/
class SubjectController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/subject",
     *     tags={"Subject"},
     *     description="View All",
     *     operationId="findAllSubject",
     *     @OA\Response(response="default", description="Success get data")
     * )
     */
    public function index()
    {
      $subject = Subject::orderBy('id', 'DESC')->get();
      return $this->success(['subject' => $subject]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/subject",
     *     tags={"Subject"},
     *     description="Add new",
     *     operationId="postSubject",
     *     @OA\RequestBody(
     *         description="Add new Subject",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Subject Name",
     *                     property="subject_name",
     *                     type="string"
     *                 ),
     *                 required={"subject_name"}
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
            'subject_name' => 'required',
        ]);
        if( Subject::where('subject_name', '=', $request->subject_name)->exists())
        {  
          return $this->error("data ready exist");
        }
        else 
        {
          $subject = New Subject;
          $subject->subject_name = $request->subject_name;
          $subject->created_by = Auth::User()->id;
          $subject->save();

          return $this->success(['subject' => $subject ]);
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
     *     path="/subject/{id}",
     *     tags={"Subject"},
     *     description="View By Id",
     *     operationId="showSubject",
     *     @OA\Parameter(
     *         description="ID of Subject",
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
        $subject = Subject::find($id);
        return $this->success(['subject' => $subject]);
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
     *     path="/subject/{id}",
     *     tags={"Subject"},
     *     description="Update Data",
     *     operationId="putSubject",
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="subject_name",
     *                     type="string"
     *                 ),
     *          )
     *     ),
     *     @OA\Parameter(
     *         description="ID of Subject",
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
          'subject_name' => 'required',
      ]);

      if( Subject::where('subject_name', '=', $request->subject_name)->exists())
      {  
        return $this->error("data ready exist");
      }
      else 
      {
        $subject = Subject::find($id);
        $subject->subject_name = $request->subject_name;
        $subject->updated_by = Auth::User()->id;
        $subject->save();
          
        return $this->success(['subject' => $subject]);
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
     *     path="/subject/{id}",
     *     tags={"Subject"},
     *     description="Delete Data",
     *     operationId="destroySubject",
     *     @OA\Parameter(
     *         description="ID of Subject",
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
      $subject = Subject::destroy($id);
      return $this->success(['subject' => $subject]);
    }

     /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/subject/search/{name}",
     *     tags={"Subject"},
     *     description="Search Data",
     *     operationId="searchSubject",
     *     @OA\Parameter(
     *         description="Name of Subject",
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
      $subject = Subject::where('subject_name', 'like', '%'.$name.'%')->get();
      return $this->success(['subject' => $subject]);
    }
}
