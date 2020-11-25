<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public function babies() {
        return $this->belongsToMany('App\Models\Baby');
    }
}
