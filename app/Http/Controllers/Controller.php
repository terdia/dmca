<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	/**
	 * The user that is currently signed In
	 *
	 * @var \App\User|Null
	 */
	protected $user;

	/**
	 * is the user signed In?
	 *
	 * @var \App\User|Null
	 */
	protected $signedIn;


	/**
	 * Create a new Controller Instance
	 */
	public function __construct(){
		$this->user = $this->signedIn = Auth::user();
	}
}
