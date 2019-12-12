<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    protected static function boot() {
      parent::boot();
      static::creating(function ($category) {
        $category->slug = str_slug($category->name);
      });
    }

    public function getRouteKeyName() {
      return 'slug';
    }

    public function questions() {
      return $this->hasMany(Question::class);
    }
}
