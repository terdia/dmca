<?php namespace App\Http\Controllers;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Notice;
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
        return Auth::user()->notices;
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
        //store the template in a session variable
        session()->flash('dmca', $data);
        return view('notices.confirm', compact('template'));
    }

    /**
     * Store a new DMCA Notice
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request){
        $this->createNotice($request);

        //fire up email
        return redirect('notices');
    }

    /**
     * Compile the DMCA Template from the form data
     *
     * @param $data
     * @param Guard $auth
     * @return mixed
     */
    public function complileDmcaTemplate($data, Guard $auth){
        $data = $data + [
                'name' => $auth->user()->name,
                'email' => $auth->user()->email,
            ];
        return view()->file(app_path('Http/Templates/dmca.blade.php'), $data);
    }

    /**
     * Create and persist a new DMCA Notice
     *
     * @param Request $request
     */
    private function createNotice(Request $request)
    {
        $data = session()->get('dmca');
        //$notice = Notice::open($data)->useTemplate($request->input('template'));
        Auth::user()->notices()->save(Notice::open($data)->useTemplate($request->input('template')));
    }


}
