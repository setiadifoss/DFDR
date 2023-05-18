<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Traits\ApiResponser;
use App\Models\News;
use Illuminate\Http\Request;

use Auth;

/**
 *
 * @OA\Tag(
 *     name="News",
 *     description="API Endpoints of Projects"
 * )
*/
class NewsController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/news",
     *     tags={"News"},
     *     description="View All",
     *     operationId="findAllNews",
     *     @OA\Response(response="default", description="Success get data")
     * )
     */
    public function index()
    {
      // dd("die");
      $news = News::orderBy('id', 'DESC')->get();

      foreach ($news as $key ) {

        $str = strip_tags($key->news_desc);
        if (strlen($str) > 30) {

            // truncate string
            $strCut = substr($str, 0, 30);
            $endPoint = strrpos($strCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $str = $endPoint? substr($strCut, 0, $endPoint) : substr($strCut, 0);
            $str .= ' ..';
        }

        $key->news_desc = $str;
      }

      return $this->success(['news' => $news]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     /**
     * @OA\Post(
     *     path="/news",
     *     tags={"News"},
     *     description="Add new",
     *     operationId="postNews",
     *     @OA\RequestBody(
     *         description="Add new News",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="News Title",
     *                     property="news_title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     description="News Description",
     *                     property="news_desc",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     description="News Thumbnail",
     *                     property="news_thumb",
     *                     type="file"
     *                 ),
     *                 required={"news_title","news_desc","news_thumb"}
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
      // dd(Auth::User()->id);
        $request->validate([
            'news_title' => 'required',
            'news_desc' => 'required',
            'news_thumb' => 'required|image',
        ]);
        if ($news_thumb = $request->file('news_thumb')) {
          $path = public_path() . '/storage/uploads/news_thumb';
          $news_thumb->move($path, $news_thumb->getClientOriginalName());
          $news = New News;
          $news->news_title = $request->news_title;
          $news->news_desc = $request->news_desc;
          $news->news_thumb = $path . '/' .$news_thumb->getClientOriginalName();
          $news->news_thumb_name = $news_thumb->getClientOriginalName();
          $news->created_by = Auth::User()->id;
          $news->save();
  
          return $this->success(['news' => $news]);
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
     *     path="/news/{id}",
     *     tags={"News"},
     *     description="View By Id",
     *     operationId="showNews",
     *     @OA\Parameter(
     *         description="ID of News",
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
        $news = News::find($id);
        return $this->success(['news' => $news]);
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
     *     path="/news/{id}",
     *     tags={"News"},
     *     description="Update Data",
     *     operationId="putNews",
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                     property="news_title",
     *                     type="string"
     *                 ),
     *              @OA\Property(
     *                     property="news_desc",
     *                     type="string"
     *                 ),
     *          )
     *     ),
     *     @OA\Parameter(
     *         description="ID of News",
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
        'news_title' => 'required',
        'news_desc' => 'required',
        // 'news_thumb' => 'required|image',
      ]);

      $news = News::find($id);

      if ($request->file('news_thumb') != "")
      {
        if ($news_thumb = $request->file('news_thumb')) 
        {
          $path = public_path() . '/storage/uploads/news_thumb';
          $news_thumb->move($path, $news_thumb->getClientOriginalName());
        }
        
        $news->news_thumb = $path . '/' .$news_thumb->getClientOriginalName();
        $news->news_thumb_name = $news_thumb->getClientOriginalName();
      }
      
      $news->news_title = $request->news_title;
      $news->news_desc = $request->news_desc;
      $news->updated_by = Auth::User()->id;
      $news->save();

      return $this->success(['news' => $news]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *     path="/news/{id}",
     *     tags={"News"},
     *     description="Delete Data",
     *     operationId="destroyNews",
     *     @OA\Parameter(
     *         description="ID of News",
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
      $news = News::destroy($id);
      return $this->success(['news' => $news]);
    }

     /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/news/search/{name}",
     *     tags={"News"},
     *     description="Search Data",
     *     operationId="searchNews",
     *     @OA\Parameter(
     *         description="News Title",
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
      $news = News::where('news_title', 'like', '%'.$name.'%')->get();
      return $this->success(['news' => $news]);
    }
}
