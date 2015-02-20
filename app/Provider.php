<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model {
    /*
     * No timestamp for our provider
    */
    public $timestamps = false;

    /*
     * Specify fill_able fields for provider
    */
    protected $fillable = [
        'name',
        'copyright_email'
    ];

}
