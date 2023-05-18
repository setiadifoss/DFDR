<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 *
 * @OA\Tag(
 *     name="Pre Use",
 *     description="API Endpoints of Projects"
 * )
*/
class PreUseController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/preUsed",
     *     tags={"Pre Use"},
     *     description="Pre Use",
     *     @OA\Response(response="default", description="Pre Use Index")
     * )
     */
    public function index()
    {
        $file = storage_path('installed');
        $exists = false;

        if(file_exists($file)){
            $exists = true;
        }
        
        return $this->success(['data' => true, 'file' => $exists]);
    }
}
