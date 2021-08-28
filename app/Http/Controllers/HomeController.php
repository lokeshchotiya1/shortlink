<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShortLink;
use App\UrlRedirectHistory;
use Carbon\Carbon;
use Str;
use DB;

class HomeController extends Controller {
    
    public function index()
    {
         $shortLinks = ShortLink::select("short_links.*",

             DB::raw("(select count(id) from url_redirect_history where url_id = short_links.id ) as url_open_count"))

             ->groupby("short_links.id")
             ->get();

        return view('home', compact('shortLinks'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'link' => 'required|url'
        ]);

        $input['link'] = $request->link;
        $input['code'] = Str::random(6);

        ShortLink::create($input);

        return redirect('generate-shorten-link')
             ->with('success', 'Shorten Link Generated Successfully!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shortenLink($code)
    {
        $find = ShortLink::where('code', $code)->first();

        return redirect($find->link);
    }


    public function save_user_redirect(Request $request)
    {
        $data = $request->all();
        #create or update your data here

        $url_data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $url_data['url_id'] = $data['url_id'];

        $url_history_data = UrlRedirectHistory::create($url_data);

        $shortLink = ShortLink::find($url_data['url_id']);

        $url = ENV('APP_URL').'/'.$shortLink->code;

        return response()->json(['success'=>'URL Successfully open.','url' => $url ]);
    }


}