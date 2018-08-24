<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name', 'author_id',
    ];

    /**
     * Get the author of the book
     */
    public function author()
    {
        return $this->belongsTo('App\User', 'author_id', 'id');
    }

    // depending on server configuration it can be string or integer so it's better to cast to int
    protected $casts = [
        'author_id' => 'integer',
    ];

}
