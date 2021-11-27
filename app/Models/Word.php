<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text',
    ];


    public function words()
    {
        return $this->belongsToMany('App\Models\Document', 'document_word', 'word_id', 'document_id')->withPivot(['occurence']);
    }
}
