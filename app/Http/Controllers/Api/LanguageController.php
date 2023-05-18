<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Traits\ApiResponser;
use App\Models\Language;
use Illuminate\Http\Request;

use Auth;

/**
 *
 * @OA\Tag(
 *     name="Language",
 *     description="API Endpoints of Projects"
 * )
*/
class LanguageController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/language",
     *     tags={"Language"},
     *     description="View All",
     *     operationId="findAllLanguage",
     *     @OA\Response(response="default", description="Success get data")
     * )
     */
    public function index()
    {
      $language = Language::orderBy('id', 'DESC')->get();
      return $this->success(['language' => $language]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/language",
     *     tags={"Language"},
     *     description="Add new",
     *     operationId="postLanguage",
     *     @OA\RequestBody(
     *         description="Add new Language",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Language Name",
     *                     property="language_name",
     *                     type="string"
     *                 ),
     *                 required={"language_name"}
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
            'language_name' => 'required',
        ]);

        if( Language::where('language_name', '=', $request->language_name)->exists())
        {  
          return $this->error("data ready exist");
        }
        else 
        {
          $language = New Language;
          $language->language_name = $request->language_name;
          $language->created_by = Auth::User()->id;
          $language->save();

          return $this->success(['language' => $language ]);
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
     *     path="/language/{id}",
     *     tags={"Language"},
     *     description="View By Id",
     *     operationId="showLanguage",
     *     @OA\Parameter(
     *         description="ID of Language",
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
        $language = Language::find($id);
        return $this->success(['language' => $language]);
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
     *     path="/language/{id}",
     *     tags={"Language"},
     *     description="Update Data",
     *     operationId="putLanguage",
     *     @OA\RequestBody(
     *         description="Add new Language",
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="language_name",
     *                     type="string"
     *                 ),
     *          )
     *     ),
     *     @OA\Parameter(
     *         description="ID of Language",
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
          'language_name' => 'required',
        ]);

        if( Language::where('language_name', '=', $request->language_name)->exists())
        {  
          return $this->error("data ready exist");
        }
        else 
        {
          $language = Language::find($id);
          $language->language_name = $request->language_name;
          $language->updated_by = Auth::User()->id;
          $language->save();
          
          return $this->success(['language' => $language]);
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
     *     path="/language/{id}",
     *     tags={"Language"},
     *     description="Delete Data",
     *     operationId="destroyLanguage",
     *     @OA\Parameter(
     *         description="ID of Language",
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
      $language = Language::destroy($id);
      return $this->success(['language' => $language]);
    }

     /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/language/search/{name}",
     *     tags={"Language"},
     *     description="Search Data",
     *     operationId="searchLanguage",
     *     @OA\Parameter(
     *         description="Name of Language",
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
      $language = Language::where('language_name', 'like', '%'.$name.'%')->get();
      return $this->success(['language' => $language]);
    }
}
