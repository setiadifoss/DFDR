<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Traits\ApiResponser;
use App\Models\Category;
use Illuminate\Http\Request;

use Auth;

/**
 *
 * @OA\Tag(
 *     name="Category",
 *     description="API Endpoints of Projects"
 * )
*/
class CategoryController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     /**
     * @OA\Get(
     *     path="/category",
     *     tags={"Category"},
     *     description="View All",
     *     operationId="findAllCategory",
     *     @OA\Response(response="default", description="Success get data")
     * )
     */
    public function index()
    {
      // dd("die");
      $category = Category::orderBy('id', 'DESC')->get();
      return $this->success(['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/category",
     *     tags={"Category"},
     *     description="Add new",
     *     operationId="postCategory",
     *     @OA\RequestBody(
     *         description="Add new Category",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Category Name",
     *                     property="category_name",
     *                     type="string"
     *                 ),
     *                 required={"category_name"}
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
            'category_name' => 'required',
        ]);
        if( Category::where('category_name', '=', $request->category_name)->exists()){
          
          return $this->error("data ready exist");
        }else {
          $category = New Category;
          $category->category_name = $request->category_name;
          $category->created_by = Auth::User()->id;
          $category->save();
          
          return $this->success(['category' => $category ]);
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
     *     path="/category/{id}",
     *     tags={"Category"},
     *     description="View By Id",
     *     operationId="showCategory",
     *     @OA\Parameter(
     *         description="ID of Category",
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
        $category = Category::find($id);
        return $this->success(['category' => $category]);
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
     *     path="/category/{id}",
     *     tags={"Category"},
     *     description="Update Data",
     *     operationId="putCategory",
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="category_name",
     *                     type="string"
     *                 ),
     *          )
     *     ),
     *     @OA\Parameter(
     *         description="ID of Category",
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
        'category_name' => 'required',
      ]);

      if( Category::where('category_name', '=', $request->category_name)->exists())
      {   
        return $this->error("data ready exist");
      }
      else 
      {
        $category = Category::find($id);
        $category->category_name = $request->category_name;
        $category->updated_by = Auth::User()->id;
        $category->save();
        
        return $this->success(['category' => $category]);
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
     *     path="/category/{id}",
     *     tags={"Category"},
     *     description="Delete Data",
     *     operationId="destroyCategory",
     *     @OA\Parameter(
     *         description="ID of Category",
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
      $category = Category::destroy($id);
      return $this->success(['category' => $category]);
    }

     /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/category/search/{name}",
     *     tags={"Category"},
     *     description="Search Data",
     *     operationId="searchCategory",
     *     @OA\Parameter(
     *         description="Name of Category",
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
      $category = Category::where('category_name', 'like', '%'.$name.'%')->get();
      return $this->success(['category' => $category]);
    }
}
