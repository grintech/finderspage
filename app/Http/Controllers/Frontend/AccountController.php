<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        $accounts = auth()->user()->accounts;
        return view('accounts.index', compact('accounts'));
    }

    public function switchAccount(Request $request, $accountId)
    {
        $account = auth()->user()->accounts()->find($accountId);

        if (!$account) {
            return redirect()->route('accounts.index')->with('error', 'Account not found.');
        }

        // Store the selected account's ID in the session for switching
        $request->session()->put('active_account', $account->id);

        return redirect()->route('accounts.index')->with('success', 'Account switched successfully.');
    }




    public function Remove_Switch_Account(Request $request)
    {

        $id ='2132';

        $cookieValue = Cookie::get('loginUser');


        $uId = explode(',', $cookieValue);
            unset($uId['0']);
               dd($uId);

              foreach ($uId as $key => $value) {
                
              }
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
