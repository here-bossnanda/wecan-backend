<?php

namespace App\Http\Controllers\Backend;

use App\AktivasiWecan;
use App\Http\Controllers\Controller;
use App\PanitiaDosen;
use App\PanitiaMahasiswa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $exists = AktivasiWecan::where('status',1)->exists();
        if($exists){
            $wecan = AktivasiWecan::where('status',1)->first();
            $mahasiswa = PanitiaMahasiswa::where('aktivasi_wecan_id',$wecan->id)->count();
            $dosen = PanitiaDosen::where('aktivasi_wecan_id',$wecan->id)->count();
            return view('home',compact('wecan','mahasiswa','dosen'));
        }
        return view('home');
    }
}
