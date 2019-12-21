<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ReplyNotificationResource;

class ReplyNotification extends Controller
{
  public function __construct() {
      $this->middleware('JWT');
  }

    public function index() {
      return [
        'readNotifications' => ReplyNotificationResource::collection(auth()->user()->readNotifications()->get()),
        'unreadNotifications' => ReplyNotificationResource::collection(auth()->user()->unreadNotifications()->get())
      ];
    }

    public function markAsRead(Request $request) {
      auth()->user()->notifications->where('id', $request->id)->markAsRead();
    }
}
