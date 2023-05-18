<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\ApiResponser;
use App\Models\User;
use App\Models\NotifyUser;
use App\Models\NotifyUpload;
use App\Models\NotifyApproval;
use Notification;
use App\Notifications\uploadFormNotification;

/**
 *
 * @OA\Tag(
 *     name="Notification",
 *     description="API Endpoints of Projects"
 * )
*/
class NotificationController extends Controller
{
  use ApiResponser;

  public function __construct()
    {
        // $this->middleware('auth');
    }
  
    /**
     * @OA\Get(
     *     path="/get-notification",
     *     tags={"Notification"},
     *     description="View All",
     *     operationId="getNotification",
     *     @OA\Response(response="default", description="Success get data"),
     *     security={{"bearerAuth":{}}}, 
     * )
     */
  public function sendOfferNotification() {
    $userSchema = User::first();

    $offerData = [
        'name' => 'ADMIN',
        'body' => 'New Uploaded Form.',
        'thanks' => 'Thank you',
        'offerText' => 'Check out the offer',
        'offerUrl' => url('/'),
        'offer_id' => 777
    ];
    $userSchema->notify(new uploadFormNotification($offerData));
    // dd($userSchema->notifications);
    
    return $this->success($offerData,"Success Send Notification");
  }

  /**
   * @OA\Get(
   *     path="/get-notification-user",
   *     tags={"Notification"},
   *     description="View All",
   *     operationId="getNotificationUser",
   *     @OA\Response(response="default", description="Success get data"),
   * )
   */
  public function userNew() {
    $UserNotif = NotifyUser::orderBy('id', 'DESC')->get();
    $panjang = NotifyUser::where('status', 0)->orderBy('id', 'DESC')->get();
    return $this->success(['listNotif' => $UserNotif, 'length' => count($panjang)]);
  }

  /**
   * @OA\Get(
   *     path="/get-notification-upload",
   *     tags={"Notification"},
   *     description="View All",
   *     operationId="getNotificationUpload",
   *     @OA\Response(response="default", description="Success get data"),
   * )
   */
  public function UploadNew() {
    $UploadNotif = NotifyUpload::orderBy('id', 'DESC')->get();
    $panjang = NotifyUpload::where('status', 0)->orderBy('id', 'DESC')->get();
    return $this->success(['listNotif' => $UploadNotif, 'length' => count($panjang)]);
  }

  /**
   * @OA\Get(
   *     path="/get-notification-approval/{userId}",
   *     tags={"Notification"},
   *     description="View All",
   *     operationId="getNotificationApprovalUser",
   *     @OA\Parameter(
   *         description="User Id",
   *         in="path",
   *         name="userId",
   *         required=true,
   *         @OA\Schema(
   *             type="integer",
   *             format="int64"
   *         ),
   *     ),
   *     @OA\Response(response="default", description="Success get data"),
   * )
   */
  public function ApprovalNew($userId) {
    $UploadNotif = NotifyApproval::where('user_id',$userId)->orderBy('id', 'DESC')->get();
    $panjang = NotifyApproval::where(['user_id' => $userId, 'status' => 0])->get();
    return $this->success(['listNotif' => $UploadNotif, 'length' => count($panjang)]);
  }

  /**
   * @OA\Get(
   *     path="/read-notification-user/{id}",
   *     tags={"Notification"},
   *     description="View All",
   *     operationId="readNotificationUser",
   *     @OA\Parameter(
   *         description="Id Notification User",
   *         in="path",
   *         name="Id",
   *         required=true,
   *         @OA\Schema(
   *             type="integer",
   *             format="int64"
   *         ),
   *     ),
   *     @OA\Response(response="default", description="Success get data"),
   * )
   */
  public function userNewRead($id) {
    $UserNotif = NotifyUser::where('id',$id)->update(array('status' => 1));
    return $this->success(['listNotif' => $UserNotif]);
  }

  /**
   * @OA\Get(
   *     path="/read-notification-upload/{id}",
   *     tags={"Notification"},
   *     description="View All",
   *     operationId="readNotificationUpload",
   *     @OA\Parameter(
   *         description="Id Notification Upload",
   *         in="path",
   *         name="Id",
   *         required=true,
   *         @OA\Schema(
   *             type="integer",
   *             format="int64"
   *         ),
   *     ),
   *     @OA\Response(response="default", description="Success get data"),
   * )
   */
  public function UploadNewRead($id) {
    $UploadNotif = NotifyUpload::where('id',$id)->update(array('status' => 1));
    return $this->success(['listNotif' => $UploadNotif]);
  }

  /**
   * @OA\Get(
   *     path="/read-notification-approval/{id}",
   *     tags={"Notification"},
   *     description="View All",
   *     operationId="readNotificationApproval",
   *     @OA\Parameter(
   *         description="Id Notification Approval",
   *         in="path",
   *         name="Id",
   *         required=true,
   *         @OA\Schema(
   *             type="integer",
   *             format="int64"
   *         ),
   *     ),
   *     @OA\Response(response="default", description="Success get data"),
   * )
   */
  public function ApprovalNewRead($id) {
    $UploadNotif = NotifyApproval::where('id',$id)->update(array('status' => 1));
    return $this->success(['listNotif' => $UploadNotif]);
  }
}
