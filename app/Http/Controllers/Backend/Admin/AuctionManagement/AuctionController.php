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
        $this->middleware('permission:auction-feature', ['only' => ['feature']]);
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

    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->auctionService->getAuctions()->onlyTrashed()->with(['deleter_admin']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($auction) {
                    return "<span class='badge " . $auction->status_color . "'>$auction->status_label</span>";
                })
                ->editColumn('is_featured', function ($auction) {
                    return "<span class='badge " . $auction->featured_color . "'>$auction->featured_label</span>";
                })
                ->editColumn('deleted_by', function ($auction) {
                    return $auction->deleter_name;
                })
                ->editColumn('deleted_at', function ($auction) {
                    return $auction->deleted_at_formatted;
                })
                ->editColumn('action', function ($auction) {
                    $menuItems = $this->trashedMenuItems($auction);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'is_featured', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.auction_management.auction.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'auction-m.auction.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['auction-restore']
            ],
            [
                'routeName' => 'auction-m.auction.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['auction-permanent-delete']
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
            session()->flash('error', 'Auction creation failed!');
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
        $data['products'] = $this->productService->getProducts()->active()->select(['id', 'name'])->get();
        $data['auction'] = $this->auctionService->getAuction($id);;
        return view('backend.admin.auction_management.auction.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuctionRequest $request, string $id)
    {

        try {
            $validated = $request->validated();
            $this->auctionService->update($id, $validated);
            session()->flash('success', 'Auction updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Auction update failed!');
            throw $e;
        }
        return redirect()->route('auction-m.auction.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->auctionService->delete($id);
            session()->flash('success', 'Auction deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Auction delete failed!');
            throw $e;
        }
        return redirect()->route('auction-m.auction.index');
    }

    public function feature($id): RedirectResponse
    {
        try {
            $this->auctionService->toggleFeature($id);
            session()->flash('success', 'Auction feature updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Auction feature update failed!');
            throw $e;
        }
        return redirect()->route('auction-m.auction.index');
    }
    public function restore(string $id): RedirectResponse
    {
        try {
            $this->auctionService->restore($id);
            session()->flash('success', 'Auction restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Auction restore failed!');
            throw $e;
        }
        return redirect()->route('auction-m.auction.recycle-bin');
    }

    /**
     * Remove the specified resource from storage permanently.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function permanentDelete(string $id): RedirectResponse
    {
        try {
            $this->auctionService->permanentDelete($id);
            session()->flash('success', 'Auction permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Auction permanent delete failed!');
            throw $e;
        }
        return redirect()->route('auction-m.auction.recycle-bin');
    }
}
