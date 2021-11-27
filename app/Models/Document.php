<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public function words()
    {
        return $this->belongsToMany('App\Models\Word', 'document_word', 'document_id', 'word_id')->withPivot(['occurence']);
    }
}
