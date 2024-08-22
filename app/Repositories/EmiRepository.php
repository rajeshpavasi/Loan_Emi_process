<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\LoanDetail;
use DB;
use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Support\Facades\Schema;

class EmiRepository implements EmiRepositoryInterface
{
    /*getting all the loan details*/
    public function all()
    {
        return LoanDetail::where("status", 1)->get();
    }

    /*getting all the Emi details*/
    public function emidetails()
    {
        $LoanDetail = LoanDetail::where("status", 1)->get();

        $dateCalculate = DB::select(
            "SELECT MIN(first_payment_date) as first, MAX(last_payment_date) as last FROM loan_details where status=1"
        );

        $months = $this->dateCalculation(
            $dateCalculate[0]->first,
            $dateCalculate[0]->last,
            1
        );

        //drop the table
        if (Schema::hasTable("emi_details")) {
            $emi_details_table_drop = "DROP TABLE`emi_details`;";
            DB::statement($emi_details_table_drop);
        }
        //emi_details table creation
        $emi_details_table_create =
            "CREATE TABLE `emi_details` ( `clientid` int(10) UNSIGNED NOT NULL," .
            implode(" double(20,2) NULL DEFAULT '0.0', ", $months) .
            " double(20,2) NULL DEFAULT '0.0' );";
        DB::statement($emi_details_table_create);

        foreach ($LoanDetail as $emi) {
            $emidetail = [];
            $emiAmt = $emi->loan_amount / $emi->num_of_payment;
            $emidetail["clientid"] = $emi->clientid;

            $client_months = $this->dateCalculation(
                $emi->first_payment_date,
                $emi->last_payment_date
            );

            foreach ($client_months as $l => $single) {
                $last_element = count($client_months) - 1;
                $checkamt = $emiAmt * $emi->num_of_payment - $emi->loan_amount;

                if ($checkamt > 0 && $client_months[$last_element] == $l) {
                    $emiAmt = $emiAmt - $checkamt;
                }
                if ($checkamt < 0 && $client_months[$last_element] == $l) {
                    $emiAmt = $emiAmt + $checkamt;
                }

                $emidetail[$single] = $emiAmt;
            }
            DB::table("emi_details")->insert($emidetail);
        }
        $emi_details_table_data = "select * from emi_details;";
        $EmiDetail = DB::select($emi_details_table_data);
        $emidata = collect($EmiDetail)
            ->map(function ($x) {
                return (array) $x;
            })
            ->toArray();
        return ["EmiDetailData" => $emidata, "months" => $months];
    }

    /*get date calculations*/
    function dateCalculation($startdate, $enddate, $column = null)
    {
        $start = (new DateTime($startdate))->modify("first day of this month");
        $end = (new DateTime($enddate))->modify("first day of next month");
        $interval = DateInterval::createFromDateString("1 month");
        $period = new DatePeriod($start, $interval, $end);

        $months = [];
        foreach ($period as $dt) {
            if ($column == 1) {
                $months[] = "`" . $dt->format("Y_M") . "`";
            } else {
                $months[] = $dt->format("Y_M");
            }
        }

        return $months;
    }
}
