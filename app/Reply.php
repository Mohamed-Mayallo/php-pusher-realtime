<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    public function question() {
      return $this->belongsTo(Question::class);
    }

    public function replies() {
      return $this->hasMany(Reply::class);
    }
}
