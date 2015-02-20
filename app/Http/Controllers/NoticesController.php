<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Provider;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;


class NoticesController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }
    /*
     * Return notices
    */
    public function index(){
        return 'All notices';
    }

    /*
     * Create a new DMCA Notice
    */
    public function create(){

        //get list of service provider
        $providers = Provider::lists('name', 'id');

        //return a view with provider list
        return view('notices.create', compact('providers'));
    }

    /*
     * Ask the user to confirm the DMCA that will be delivered
     *
    */
    public function confirm(Requests\PrepareNoticeRequest $request, Guard $auth){
        $template = $this->complileDmcaTemplate($data = $request->all(), $auth);
        session()->flash('dmca', $data);
        return view('notices.confirm', compact('template'));
    }

    public function store(){
        $data = session()->get('dmca');
        return $data;
    }

    /*
     * Compile the DMCA Template from the form data
     *
    */
    public function complileDmcaTemplate($data, Guard $auth){
        $data = $data + [
                'name' => $auth->user()->name,
                'email' => $auth->user()->email,
            ];
        return view()->file(app_path('Http/Templates/dmca.blade.php'), $data);
    }


}
