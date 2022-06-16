<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MoneyConvertMail;
use App\Models\MoneyConverter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MoneyConvertController extends Controller
{
    protected $model;

    public function __construct(MoneyConverter $model)
    {
        $this->middleware('auth');
        $this->model = $model;
    }

    public function index()
    {
        return view('money-convert');
    }

    public function result()
    {
        $data = $this->model
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->first();
        return response()->json($data, 200);
    }

    public function history()
    {
        $data = $this->model
            ->where('user_id', Auth::id())
            ->get();
        return response()->json($data, 200);
    }

    public function mail()
    {
        $data = $this->model
            ->with('user')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->first();
        Mail::send(new MoneyConvertMail($data));
        return response()->json($data, 200);
    }
}
