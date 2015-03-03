<?php namespace App\Http\Controllers;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Notice;
use App\Provider;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NoticesController extends Controller {

    public function __construct(){
        $this->middleware('auth');
        parent::__construct();
    }

    /**
     * Return notices
     *
     * @return mixed
     */
    public function index(){
        $notices = $this->user->notices()->where('content_removed', 0)->get();
        return view('notices.index', compact('notices'));
    }

    /**
     * Create a new DMCA Notice
     *
     * @return \Illuminate\View\View
     */
    public function create(){
        //get list of service provider
        $providers = Provider::lists('name', 'id');
        //return a view with provider list
        return view('notices.create', compact('providers'));
    }

    /**
     * Ask the user to confirm the DMCA that will be delivered
     *
     * @param Requests\PrepareNoticeRequest $request
     * @return \Illuminate\View\View
     */
    public function confirm(Requests\PrepareNoticeRequest $request){
        $template = $this->complileDmcaTemplate($data = $request->all());
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
        $notice = $this->createNotice($request);

        //fire up email to service provider
        Mail::send(['text' => 'emails.dmca'], compact('notice'), function ($message) use ($notice){
            $message->from($notice->getOwnerEmail())
                ->to($notice->getRecipientEmail())
                ->subject('DMCA Notice');
        });

        flash('Your DMCA Notice has been delivered!');
        return redirect('notices');
    }

    /**
     * @param $notice_id
     * @param Request $request
     * @return mixed
     */
    public function update($notice_id, Request $request){
        $isRemoved = $request->has('content_removed');
        //flash('Updated successfully!');
        return Notice::findOrFail($notice_id)->update(['content_removed' => $isRemoved]);
    }

    /**
     * Compile the DMCA Template from the form data
     *
     * @param $data
     * @return mixed
     */
    public function complileDmcaTemplate($data){
        $data = $data + [
                'name' => $this->user->name,
                'email' => $this->user->email,
            ];
        return view()->file(app_path('Http/Templates/dmca.blade.php'), $data);
    }

    /**
     *  Create and persist a new DMCA Notice
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function createNotice(Request $request)
    {
        $notice = session()->get('dmca') + ['template' => $request->input('template')];
        //$notice = Notice::open($data)->useTemplate($request->input('template'));
        $notice = $this->user->notices()->create($notice);

        return $notice;
    }

}
