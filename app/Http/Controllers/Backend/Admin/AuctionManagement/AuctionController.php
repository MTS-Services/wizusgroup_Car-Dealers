<?php

namespace App\Http\Controllers\Backend\Admin\AuctionManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuctionManagement\AuctionRequest;
use App\Models\Auction;
use App\Services\Admin\AuctionManagement\AuctionService;
use App\Services\Admin\ProductManagement\ProductService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AuctionController extends Controller
{

    protected AuctionService $auctionService;
    protected ProductService $productService;

    public function __construct(AuctionService $auctionService, ProductService $productService)
    {
        $this->auctionService = $auctionService;
        $this->productService = $productService;
        $this->middleware('auth:admin');
        $this->middleware('permission:auction-list', ['only' => ['index']]);
        $this->middleware('permission:auction-details', ['only' => ['show']]);
        $this->middleware('permission:auction-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:auction-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:auction-delete', ['only' => ['destroy']]);
        $this->middleware('permission:auction-status', ['only' => ['status']]);
        $this->middleware('permission:auction-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:auction-restore', ['only' => ['restore']]);
        $this->middleware('permission:auction-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->auctionService->getAuctions()->with(['creater_admin']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($auction) {
                    return "<span class='badge " . $auction->status_color . "'>$auction->status_label</span>";
                })
                ->editColumn('is_featured', function ($auction) {
                    return "<span class='badge " . $auction->featured_color . "'>$auction->featured_label</span>";
                })
                ->editColumn('created_by', function ($auction) {
                    return $auction->creater_name;
                })
                ->editColumn('created_at', function ($auction) {
                    return $auction->created_at_formatted;
                })
                ->editColumn('action', function ($auction) {
                    $menuItems = $this->menuItems($auction);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'is_featured', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.auction_management.auction.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['auction-details']
            ],
            [
                'routeName' => 'auction-m.auction.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['auction-edit']
            ],
            [
                'routeName' => 'auction-m.auction.feature',
                'params' => [encrypt($model->id)],
                'label' => $model->featured_btn_label,
                'permissions' => ['auction-feature']
            ],
            [
                'routeName' => 'auction-m.auction.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['auction-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['products'] = $this->productService->getProducts()->active()->select(['id', 'name'])->get();
        return view('backend.admin.auction_management.auction.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuctionRequest $request)
    {
        try {
            $validated = $request->validated();
            $this->auctionService->create($validated);
            session()->flash('success', 'Auction created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Something went wrong, please try again');
            throw $e;
        }
        return redirect()->route('auction-m.auction.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->auctionService->getAuction($id);
        $data->load(['creater_admin', 'updater_admin', 'product']);
        $data->product_name = $data?->product?->name;   
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
