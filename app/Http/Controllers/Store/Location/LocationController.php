<?php

namespace App\Http\Controllers\Store\Location;

use App\Models\Shopper\Shopper;
use App\Http\Controllers\Controller;
use App\Models\Store\Location\Location;
use Illuminate\Http\Request;
use App\Services\Store\Location\LocationService;
use App\Http\Requests\Store\Location\LocationQueueRequest;
use App\Http\Requests\Store\Location\LocationStoreRequest;
use App\Http\Requests\Store\Location\LocationCreateRequest;

/**
 * Class LocationController
 * @package App\Http\Controllers\Store
 */
class LocationController extends Controller
{
    /**
     * @var LocationService
     */
    protected $location;

    /**
     * LocationController constructor.
     * @param LocationService $location
     */
    public function __construct(LocationService $location)
    {
        $this->location = $location;
    }

    /**
     * @param Location $location
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function public(Location $location)
    {
        return view('stores.location.public')
            ->with('location', $location);
    }

    /**
     * @param LocationCreateRequest $request
     * @param string $storeUuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(LocationCreateRequest $request, string $storeUuid)
    {
        return view('stores.location.create')
            ->with('store', $storeUuid);
    }

    /**
     * @param LocationStoreRequest $request
     * @param string $storeUuid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LocationStoreRequest $request, string $storeUuid): \Illuminate\Http\RedirectResponse
    {
        $this->location->create([
            'location_name' => $request->location_name,
            'shopper_limit' => $request->shopper_limit,
            'store_id' => $storeUuid
        ]);

        return redirect()->route('store.store', ['store' => $storeUuid]);
    }

    /**
     * @param LocationQueueRequest $request
     * @param string $storeUuid
     * @param string $locationUuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function queue(LocationQueueRequest $request, string $storeUuid, string $locationUuid)
    {
        $location = $this->location->show(
            [
                'uuid' => $locationUuid
            ],
            [
                'Shoppers',
                'Shoppers.Status'
            ]
        );


        $locations = Location::wherehas('users')->where('uuid', $locationUuid)
            ->first();

        $shoppers = Shopper::where('location_id', $locations->id)->get();

        if (isset($location['shoppers']) && count($location['shoppers']) >= 1) {
            $shoppers = $this->location->getShoppers($location['shoppers']);
        }

        return view('stores.location.queue')
            ->with('location', $location)
            ->with('shoppers', $shoppers)
            ->with('store_id', $storeUuid)
            ->with('locaiton_id', $locationUuid);
    }

    public function updateLimit(Request $request, $id)
    {

        try {
            $limit = Location::find($id);

            $limit->shopper_limit   = $request->input('shopper_limit');

            $limit->save();

            return back()->with('success', 'Shopper Limit successfully updated.');
        } catch (\Exception $e) {

            return back()->with('error', 'Shopper Limit  failed to update. Try again!');
        }
    }
}
