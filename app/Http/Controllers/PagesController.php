<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PagesController extends Controller {

    /*
     * Return the home page
    */
	public function home(){
        return view('pages.home');
    }

}
