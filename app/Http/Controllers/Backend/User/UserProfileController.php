<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\User\UserPasswordUpdateRequest;
use App\Http\Requests\User\UserProfileRequest;
use App\Models\Auction;
use App\Models\ContainerReservation;
use App\Models\User;
use App\Services\AddressService;
use App\Services\Admin\AuctionManagement\AuctionService;
use App\Services\Admin\Setup\CountryService;
use App\Services\Admin\UserManagement\UserService;
use App\Services\PersonalInformationService;

class UserProfileController extends Controller
{
    protected AddressService $addressService;
    protected PersonalInformationService $personalInformationService;
    protected CountryService $countryService;
    protected UserService $userService;
    protected AuctionService $auctionService;

    public function __construct(AddressService $addressService, PersonalInformationService $personalInformationService, CountryService $countryService, UserService $userService, AuctionService $auctionService)
    {
        $this->middleware("auth:web");
        $this->addressService = $addressService;
        $this->personalInformationService = $personalInformationService;
        $this->countryService = $countryService;
        $this->userService = $userService;
        $this->auctionService = $auctionService;
    }
    public function profile()
    {
        $data['user'] = $this->userService->getUser(encrypt(user()->id));
        $data['auctions'] = $this->auctionService->getAuctions('end_date', 'asc')->withCount('auctionBids')->whereHas('auctionBids', function ($query) {
            $query->where('user_id', user()->id);
        })->with([
            'auctionBids' => function ($q) {
                $q->where('user_id', user()->id);
            },
            'auctionWatchers',
            'product.category',
        ])
        ->get();
        $data['user']->load(['personalInformation']);
        $data['address'] = $this->addressService->getAddresses()->userAddresses()->personal()->first();
        $data['countries'] = $this->countryService->getCountrys()->active()->get();
        $data['my_containers'] = $this->userService->getUser(encrypt(user()->id))->containerReservations()->with(['container.destinationPort', 'container.shippingPort'])->get();
        return view('backend.user.dashboard', $data);
    }

    public function profileUpdate(UserProfileRequest $request)
    {
        $validated = $request->validated();
        $file = $request->validated('image') &&  $request->hasFile('image') ? $request->file('image') : null;
        $this->userService->updateUserProfile(user(), $validated , $file);

        $this->personalInformationService->updatePersonalInformation(user()->personalInformation, $validated);

        session()->flash('success', 'Profile updated successfully.');
        return redirect()->back();
    }
    public function addressUpdate(AddressRequest $request)
    {
        try {
            $address = $this->addressService->getAddresses()->userAddresses()->personal()->first();
            $validated = $request->validated();
            $this->addressService->updateAddress($address, $validated);
            session()->flash('success', 'Address updated successfully.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Address update failed!');
            throw $th;
        }
        return redirect()->back();
    }
    public function passwordUpdate(UserPasswordUpdateRequest $request)
    {
        try {
            $validated = $request->validated();
            $this->userService->updateUserPassword(user(), $validated);
            session()->flash('success', 'Password updated successfully.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Password update failed!');
            throw $th;
        }
        return redirect()->back();
    }

    // Details User Bids
    public function auctionDetails($auction_slug)
    {
        $data['auction'] = Auction::withCount('auctionBids')->with(['product.category'])->where('slug', $auction_slug)->firstOrFail();
        return view('backend.user.details_my_bids', $data);
    }

    public function containerDetails($container_slug)
    {
        $data['container'] = ContainerReservation::with(['container.destinationPort', 'container.shippingPort'])->where('id', decrypt($container_slug))->firstOrFail();
        // dd($data['container']);
        return view('backend.user.details_my_container', $data);
    }
}
