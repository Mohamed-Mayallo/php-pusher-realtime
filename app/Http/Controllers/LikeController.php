<?php

namespace App\Http\Controllers;

use App\Like;
use App\Reply;
use Illuminate\Http\Request;

class LikeController extends Controller
{
  public function __construct()
    {
        $this->middleware('JWT', ['only' => ['like', 'unlike']]);
    }

  public function like(Reply $reply) {
    $reply->likes()->create([
      'user_id' => 1
    ]);
    return response('Liked');
  }

  public function unlike(Reply $reply) {
    $reply->likes()->where('user_id', '=', 1)->first()->delete();
    return response('UnLiked');
  }
}
