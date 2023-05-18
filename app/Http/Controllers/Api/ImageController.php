<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

/**
 *
 * @OA\Tag(
 *     name="Image",
 *     description="API Endpoints of Projects"
 * )
*/
class ImageController extends Controller
{
    use ApiResponser;
    /**
     * @OA\Get(
     *     path="/show-image/{imagePath}/{fileName}",
     *     tags={"Image"},
     *     description="Search Data",
     *     operationId="searchImage",
     *     @OA\Parameter(
     *         description="Image Path",
     *         in="path",
     *         name="imagePath",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="string"
     *         ),
     *     ),
     *    @OA\Parameter(
     *         description="File Name",
     *         in="path",
     *         name="fileName",
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
    public function showUploadCard($imagePath, $fileName)
    {
      $path = public_path('storage/uploads/'.$imagePath. '/' . $fileName);
      // dd($path);
      if (!File::exists($path)) {
          return $this->error("image not found", 404);
      }

      $file = File::get($path);
      $type = File::mimeType($path);

      $response = Response::make($file, 200);
      $response->header("Content-Type", $type);

      return $response;
    }
}
