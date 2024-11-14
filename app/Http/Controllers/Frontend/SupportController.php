<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Notification;
use App\Models\Support;
use App\Models\UserAuth;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $Support =  Support::where('user_id', UserAuth::getLoginId())->get();
        $new = Support::where('user_id', UserAuth::getLoginId())->where('ticket_status', 0)->count();
        $open = Support::where('user_id', UserAuth::getLoginId())->where('ticket_status', 1)->count();
        $inProgress = Support::where('user_id', UserAuth::getLoginId())->where('ticket_status', 2)->count();
        $close = Support::where('user_id', UserAuth::getLoginId())->where('ticket_status', 3)->count();
        return view('frontend.dashboard_pages.supportTicket', compact('Support', 'new', 'open', 'inProgress', 'close'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }

        return view('frontend.dashboard_pages.add_supportTicket');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $Support = new Support();
        $Support =  $Support->add_ticket_support($request);
        $user = UserAuth::getLoginUser();
        if (empty($Support)) {
            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'type' => 'ticket',
                'message' => 'A new ticket ' . $request->ticket_title . ' is created by ' . $user->first_name . '.',
            ];
            Notification::create($notice);

            $request->session()->flash('success', 'Thank you for your feedback. Will get back to you if needed. Meanwhile check out the get help page for further assistance.');
            return redirect()->route('support');
        } else {
            $request->session()->flash('error', 'Somthing went wrong. Try again later.');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $support = Support::find($id);
        return view('frontend.dashboard_pages.edit_supportTicket', compact('support'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $support = Support::find($id);
        $support = $support->update_ticket_support($request, $id);
        $user = UserAuth::getLoginUser();
        if (empty($Support)) {
            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'type' => 'ticket',
                'message' => 'ticket ' . $request->ticket_title . ' is Updated by ' . $user->first_name,
            ];
            Notification::create($notice);

            $request->session()->flash('success', 'Thank you for your feedback. Will get back to you if needed. Meanwhile check out the get help page for further assistance.');
            return redirect()->route('support');
        } else {
            $request->session()->flash('error', 'Somthing went wrong. Try again later.');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $user = UserAuth::getLoginUser();
        $support = Support::find($id);
        $notice = [
            'from_id' => UserAuth::getLoginId(),
            'to_id' => 7,
            'type' => 'ticket',
            'message' => 'Ticket ' . $support->ticket_title . ' is deleted by ' . $user->first_name . '.',
        ];
        Notification::create($notice);
        $support = $support->delete();
        if (empty($Support)) {
            return redirect()->route('support')->with(['success' => 'Your ticket is deleted successfully.']);
        } else {
            return redirect()->back()->with(['error' => 'Somthing went wrong. Try again later.']);
        }
    }
}
