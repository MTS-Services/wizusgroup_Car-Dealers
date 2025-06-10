<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\User\UserPasswordUpdateRequest;
use App\Http\Requests\User\UserProfileRequest;
use App\Models\Auction;
use App\Models\Container;
use App\Models\ContainerReservation;
use App\Models\Order;
use App\Models\User;
use App\Services\AddressService;
use App\Services\Admin\AuctionManagement\AuctionService;
use App\Services\Admin\Setup\CountryService;
use App\Services\Admin\UserManagement\UserService;
use App\Services\PersonalInformationService;
use Illuminate\Http\Request;

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
    public function profile(Request $request)
    {
        $slug = $request->slug;
        $data['page_slug'] = $slug;

        switch ($slug) {
            case 'orders':
                $query = Order::self();
                $data['orders'] = match ($request->tab) {
                    'pending' => $query->pending()->paginate(10)->withQueryString(),
                    'submitted' => $query->submitted()->paginate(10)->withQueryString(),
                    'shipped' => $query->shipped()->paginate(10)->withQueryString(),
                    'completed' => $query->completed()->paginate(10)->withQueryString(),
                    default => $query->paginate(10)->withQueryString(),
                };
                break;
            case 'containers':
                $query = Container::with([
                    'shippingPort',
                    'destinationPort',
                    'containerReservations' => function ($query) {
                        $query->where('user_id', user()->id);
                    },
                ])->whereHas('containerReservations', function ($query) {
                    $query->self();
                });
                $data['containers'] = match ($request->tab) {
                    'active' => $query->active()->paginate(3)->withQueryString(),
                    'shipped' => $query->shipped()->paginate(3)->withQueryString(),
                    'delivered' => $query->delivered()->paginate(3)->withQueryString(),
                    default => $query->paginate(3)->withQueryString(),
                };
                break;
            case 'profile':
                $user = $this->userService->getUser(encrypt(user()->id));
                $data['user'] = $user->load(['personalInformation', 'addresses']);
                $data['address'] = $user->addresses()->personal()->first();
                $data['countries'] = $this->countryService->getCountrys()->active()->get();
            default:
                $data['total_orders'] = Order::self()->count();
                $data['total_containers'] = Container::whereHas('containerReservations', function ($query) {
                    $query->self();
                })->count();
                break;
        }
        return view('backend.user.dashboard', $data);
    }

    public function profileUpdate(UserProfileRequest $request)
    {
        $validated = $request->validated();
        $file = $request->validated('image') && $request->hasFile('image') ? $request->file('image') : null;
        $this->userService->updateUserProfile(user(), $validated, $file);

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
        // $data['auction'] = Auction::withCount('auctionBids')->with(['product.category'])->where('slug', $auction_slug)->firstOrFail();
        // return view('backend.user.details_my_bids', $data);
    }

    public function containerDetails($container_slug)
    {
        $data['container'] = Container::with([
            'destinationPort',
            'shippingPort',
            'containerReservations.order',
            'containerReservations' => function ($query) {
                $query->where('user_id', user()->id);
            },
        ])->where('slug', $container_slug)->firstOrFail();
        return view('backend.user.details_my_container', $data);
    }


    public function orderDetails($order_number)
    {
        $data['order'] = Order::with([
            'shippingPort',
            'destinationPort',
            'shipping',
            'items.product',
            'items.product.brand',
            'items.product.primaryImage',
            'items.product.model',
            'container',
        ])->where('order_number', $order_number)->firstOrFail();
        return view('backend.user.order_details', $data);
    }
}
