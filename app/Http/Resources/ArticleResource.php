<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        // method ini untuk menampilkan data secara keseluruhan, sedangkan method yg di bawah berikut ini hanya menampilkan data sesuai yang kita inginkan.
        return [
            'title' => $this->title,
            'article' =>$this->body,
            'subject' => $this->subject->name,
            'published' => $this->created_at->format('d F Y'),
            'author' => $this->user->name,
        ];
    }

    public function with($request)
    {
        return ['status' => 'success'];
    }
}
