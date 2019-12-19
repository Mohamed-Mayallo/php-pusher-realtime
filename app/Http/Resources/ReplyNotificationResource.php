<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReplyNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'question' => $this->data['question'],
          'path' => $this->data['path'],
          'repliedBy' => $this->data['repliedBy'],
          'id' => $this->id,
          'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
