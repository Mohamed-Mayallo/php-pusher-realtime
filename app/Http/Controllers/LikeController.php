<?php

namespace App\Http\Controllers;

use App\Like;
use App\Reply;
use Illuminate\Http\Request;
use App\Events\LikeEvent;

class LikeController extends Controller
{
  public function __construct()
    {
        $this->middleware('JWT', ['only' => ['like', 'unlike']]);
    }

  public function like(Reply $reply) {
    $reply->likes()->create([
      'user_id' => auth()->id()
    ]);
    broadcast(new LikeEvent($reply->id, 1))->toOthers();
    return response('Liked');
  }

  public function unlike(Reply $reply) {
    $reply->likes()->where('user_id', '=', auth()->id())->first()->delete();
    broadcast(new LikeEvent($reply->id, 0))->toOthers();
    return response('UnLiked');
  }
}
