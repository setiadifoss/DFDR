<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Traits\ApiResponser;
use App\Models\Instruction;
use Illuminate\Http\Request;

use Auth;

/**
 *
 * @OA\Tag(
 *     name="Instruction",
 *     description="API Endpoints of Projects"
 * )
*/
class InstructionController extends Controller
{
  use ApiResponser;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  /**
     * @OA\Get(
     *     path="/instruction",
     *     tags={"Instruction"},
     *     description="View All",
     *     operationId="findAllInstruction",
     *     @OA\Response(response="default", description="Success get data")
     * )
     */
  public function index()
  {
    $instruction = Instruction::orderBy('id', 'DESC')->get();
    return $this->success(['instruction' => $instruction]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  /**
     * @OA\Post(
     *     path="/instruction",
     *     tags={"Instruction"},
     *     description="Add new",
     *     operationId="postInstruction",
     *     @OA\RequestBody(
     *         description="Add new Instruction",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Instruction Name",
     *                     property="instruction_name",
     *                     type="string"
     *                 ),
     *              @OA\Property(
     *                     description="Instruction desc",
     *                     property="instruction_desc",
     *                     type="string"
     *                 ),
     *                 required={"instruction_name", "instruction_desc"}
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
        'instruction_name' => 'required',
        'instruction_desc' => 'required',
      ]);
      $instruction = New Instruction;
      $instruction->instruction_name = $request->instruction_name;
      $instruction->instruction_desc = $request->instruction_desc;
      $instruction->created_by = Auth::User()->id;
      $instruction->save();
      return $this->success(['instruction' => $instruction ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  /**
     * @OA\Get(
     *     path="/instruction/{id}",
     *     tags={"Instruction"},
     *     description="View By Id",
     *     operationId="showInstruction",
     *     @OA\Parameter(
     *         description="ID of Instruction",
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
      $instruction = Instruction::find($id);
      return $this->success(['instruction' => $instruction]);
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
     *     path="/instruction/{id}",
     *     tags={"Instruction"},
     *     description="Update Data",
     *     operationId="putInstruction",
     *     @OA\RequestBody(
     *         description="Add new Instruction",
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="instruction_name",
     *                     type="string"
     *                 ),
     *              @OA\Property(
     *                     property="instruction_desc",
     *                     type="string"
     *                 ),
     *          )
     *     ),
     *     @OA\Parameter(
     *         description="ID of Instruction",
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
        'instruction_name' => 'required',
        'instruction_desc' => 'required',
      ]);
      $instruction = Instruction::find($id);
      $instruction->instruction_name = $request->instruction_name;
      $instruction->instruction_desc = $request->instruction_desc;
      $instruction->updated_by = Auth::User()->id;
      $instruction->save();
      
      return $this->success(['instruction' => $instruction]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  /**
     * @OA\Delete(
     *     path="/instruction/{id}",
     *     tags={"Instruction"},
     *     description="Delete Data",
     *     operationId="destroyInstruction",
     *     @OA\Parameter(
     *         description="ID of Instruction",
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
    $instruction = Instruction::destroy($id);
    return $this->success(['instruction' => $instruction]);
  }

   /**
   * Search for a name
   *
   * @param  str  $name
   * @return \Illuminate\Http\Response
   */
  /**
     * @OA\Get(
     *     path="/instruction/search/{name}",
     *     tags={"Instruction"},
     *     description="Search Data",
     *     operationId="searchInstruction",
     *     @OA\Parameter(
     *         description="Name of Instruction",
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
    $instruction = Instruction::where('instruction_name', 'like', '%'.$name.'%')->get();
    return $this->success(['instruction' => $instruction]);
  }
}
