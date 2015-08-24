<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];


    /**
     * Get versions.
     */
    public function versions()
    {
        return $this->hasMany('App\ApplicationVersion');
    }
}
