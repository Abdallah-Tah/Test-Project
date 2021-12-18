<?php

namespace App\Http\Controllers\Shopper;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Shopper\Shopper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Jobs\MarkShopperAsCompleted;
use Illuminate\Support\Facades\Auth;
use App\Models\Store\Location\Location;

class ShopperQueueController extends Controller
{
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createShopper(Request $request)
    {
        $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'      => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        
        $status=0;

        $location = Location::where('uuid', $request->location_id)->first();
        $location_id = $location->id;

        $count_location = Shopper::where('location_id', $location->id)->count();

        if($count_location >= $location->shopper_limit){

            $status = 3;
        }else{

            $status = 1;
        }

        try {
            //$user = Auth::user();

            $shopper = new Shopper();
            //$shopper->user_id       =  $user->id;
            $shopper->first_name       =  $request->first_name;
            $shopper->last_name       =  $request->last_name;
            $shopper->email       =  $request->email;
            $shopper->location_id       =  $location_id;
            $shopper->status_id       =  $status;
            $shopper->check_in  = Carbon::now()->toDateTimeString();
            //$shopper->check_out  = Carbon::now()->addHours(2);
            //dd($shopper);
            $shopper->save();

            $MarkShopperAsCompleted = MarkShopperAsCompleted::dispatch($shopper)->delay(now()->addHours(2));

            //$this->dispatch( new MarkShopperAsCompleted($shopper)->delay(Carbon::now()->addHours(2)));


            DB::commit();
            return back()->with('success', 'Shopper successfully added.');
        } catch (\Exception $e) {

            return back()->with('error', 'Shopper failed to add. Try again!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkOutButton(Request $request, $id)
    {
       

        try {
            if ($request->checkout != null) {

                $checkout = Shopper::find($id);
                $checkout->check_out  = Carbon::now()->toDateTimeString();
                $checkout->status_id = 2;                 
                $checkout->save();
            }


            DB::commit();
            return back()->with('success', 'Checkout successfully Confirmed.');
        } catch (\Exception $e) {

            return back()->with('error', 'Checkout failed to confirm. Try again!');
        }
    }
}
