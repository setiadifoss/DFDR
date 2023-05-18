<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 *
 * @OA\Tag(
 *     name="File",
 *     description="API Endpoints of Projects"
 * )
*/
class FileController extends Controller
{
    /**
     * @OA\Get(
     *     path="/file/{file_name}",
     *     tags={"File"},
     *     description="File",
     *     @OA\Parameter(
     *         description="File Name",
     *         in="path",
     *         name="file_name",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *     ),
     *     @OA\Response(response="default", description="Get File"),
     *    security={{"bearerAuth":{}}}, 
     * )
     */
    public function getFile($file_name)
    {
        try {
            return response()->download(storage_path('app/private_file/' . $file_name), null, [
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ], null);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'File not found',
            ], 404);
        }
        
     
    }
  
}
