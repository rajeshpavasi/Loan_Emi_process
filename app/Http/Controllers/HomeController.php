<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmiServices;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected EmiServices $emiServices)
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $LoanDetail = $this->emiServices->all();
        return view("home")->with("LoanDetail", $LoanDetail);
    }

    /**
     * Show the application EMI details.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function emi()
    {
        $EmiDetailData = $this->emiServices->emidetails();
        return view("emi")
            ->with("EmiDetail", $EmiDetailData["EmiDetailData"])
            ->with("months", $EmiDetailData["months"]);
    }
}
