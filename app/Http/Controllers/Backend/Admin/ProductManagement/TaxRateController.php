<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductManagement\TaxRateRequest;
use App\Models\Country;
use App\Models\TaxRate;
use App\Services\Admin\ProductManagement\TaxClassService;
use App\Services\Admin\ProductManagement\TaxRateService;
use App\Services\Admin\Setup\CountryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaxRateController extends Controller
{
    protected TaxRateService $taxRateService;
    protected CountryService $countryService;
    protected TaxClassService $taxClassService;
    public function __construct(TaxRateService $taxRateService, CountryService $countryService, TaxClassService $taxClassService)
    {
        $this->taxRateService = $taxRateService;
        $this->countryService = $countryService;
        $this->taxClassService = $taxClassService;

        $this->middleware('auth:admin');
        $this->middleware('permission:tax-rate-list', ['only' => ['index']]);
        $this->middleware('permission:tax-rate-details', ['only' => ['show']]);
        $this->middleware('permission:tax-rate-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:tax-rate-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tax-rate-delete', ['only' => ['destroy']]);
        $this->middleware('permission:tax-rate-status', ['only' => ['status']]);
        $this->middleware('permission:tax-rate-priority', ['only' => ['priority']]);
        $this->middleware('permission:tax-rate-compound', ['only' => ['compound']]);
        $this->middleware('permission:tax-rate-details', ['only' => ['show']]);
        $this->middleware('permission:tax-rate-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:tax-rate-restore', ['only' => ['restore']]);
        $this->middleware('permission:tax-rate-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->taxRateService->getTaxRated()
                ->with(['creater_admin']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($tax_rate) {
                    return "<span class='badge " . $tax_rate->status_color . "'>$tax_rate->status_label</span>";
                })
                ->editColumn('tax_class_id', function ($tax_rate) {
                    return $tax_rate->taxClass?->name;
                })
                ->editColumn('country_id', function ($tax_rate) {
                    return $tax_rate->country?->name . ($tax_rate->state ? "(" . $tax_rate->state?->name . ")" : "");
                })
                ->editColumn('city_id', function ($tax_rate) {
                    return  $tax_rate->city?->name;
                })
                ->editColumn('created_by', function ($tax_rate) {
                    return $tax_rate->creater_name;
                })
                ->editColumn('created_at', function ($tax_rate) {
                    return $tax_rate->created_at_formatted;
                })
                ->editColumn('action', function ($tax_rate) {
                    $menuItems = $this->menuItems($tax_rate);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'priority', 'compound', 'tax_class_id', 'country_id', 'city_id', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.tax_rate.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['tax-rate-details']
            ],
            [
                'routeName' => 'pm.tax-rate.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['tax-rate-edit']
            ],
            [
                'routeName' => 'pm.tax-rate.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['tax-rate-status']
            ],
            [
                'routeName' => 'pm.tax-rate.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['tax-rate-delete']
            ],

        ];
    }

    public function recycleBin(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->taxRateService->getTaxRated()->onlyTrashed()->with(['deleter_admin']);
            return DataTables::eloquent($query)

                ->editColumn('status', function ($tax_rate) {
                    return "<span class='badge " . $tax_rate->status_color . "'>$tax_rate->status_label</span>";
                })
                ->editColumn('tax_class_id', function ($tax_rate) {
                    return $tax_rate->taxClass?->name;
                })
                ->editColumn('country_id', function ($tax_rate) {
                    return $tax_rate->country?->name . ($tax_rate->state ? "(" . $tax_rate->state?->name . ")" : "");
                })
                ->editColumn('city_id', function ($tax_rate) {
                    return  $tax_rate->city?->name;
                })
                ->editColumn('deleted_by', function ($tax_rate) {
                    return $tax_rate->deleter_name;
                })
                ->editColumn('deleted_at', function ($tax_rate) {
                    return $tax_rate->deleted_at_formatted;
                })
                ->editColumn('action', function ($tax_rate) {
                    $menuItems = $this->trashedMenuItems($tax_rate);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'tax_class_id', 'country_id', 'city_id', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.tax_rate.recycle-bin');
    }
    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'pm.tax-rate.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['tax-rate-restore']
            ],
            [
                'routeName' => 'pm.tax-rate.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['tax-rate-permanent-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['tax_classes'] = $this->taxClassService->getTaxClasses()->active()->select(['id', 'name'])->get();
        $data['countries'] = $this->countryService->getCountrys()->active()->select(['id', 'name'])->get();
        return view('backend.admin.product_management.tax_rate.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaxRateRequest $request)
    {
        try {
            $validated = $request->validated();
            $this->taxRateService->createTaxRate($validated);
            session()->flash('success', 'Tax rate created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Tax rate create failed!');
            throw $e;
        }

        return redirect()->route('pm.tax-rate.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->taxRateService->getTaxRate($id);
        $data->load(['creater_admin', 'updater_admin', 'taxClass', 'country', 'state', 'city']);
        $data['tax_class_name'] = $data?->taxClass?->name;
        $data['country_name'] = $data?->country?->name . ($data?->state ? "(" . $data?->state?->name . ")" : "");
        $data['city_name'] = $data?->city?->name;
        $data['state_name'] = $data?->state?->name;

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $data['tax_classes'] = $this->taxClassService->getTaxClasses()->active()->select(['id', 'name'])->get();
        $data['countries'] = $this->countryService->getCountrys()->active()->select(['id', 'name'])->get();
        $data['tax_rate'] = $this->taxRateService->getTaxRate($id);
        return view('backend.admin.product_management.tax_rate.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaxRateRequest $request, string $id)
    {
        try {
            $validated = $request->validated();
            $this->taxRateService->updateTaxRate($id, $validated);
            session()->flash('success', 'Tax rate updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Tax rate update failed!');
            throw $e;
        }
        return redirect()->route('pm.tax-rate.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->taxRateService->deleteTaxRate($id);
            session()->flash('success', 'Tax rate deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Tax rate delete failed!');
            throw $e;
        }
        return redirect()->route('pm.tax-rate.index');
    }
    public function status(string $id): RedirectResponse
    {
         try {
            $this->taxRateService->toggleStatus($id);
            session()->flash('success', 'Tax rate status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Tax rate status update failed!');
            throw $e;
        }
        return redirect()->route('pm.tax-rate.index');
    }
    public function priority(string $id): RedirectResponse
    {
        $tax_priority = TaxRate::findOrFail(decrypt($id));
        $tax_priority->update(['priority' => !$tax_priority->priority, 'updated_by' => admin()->id]);
        session()->flash('success', 'Tax Rate priority updated successfully!');
        return redirect()->route('pm.tax-rate.index');
    }
    public function compound(string $id): RedirectResponse
    {
        $tax_compound = TaxRate::findOrFail(decrypt($id));
        $tax_compound->update(['compound' => !$tax_compound->compound, 'updated_by' => admin()->id]);
        session()->flash('success', 'Tax Rate compound updated successfully!');
        return redirect()->route('pm.tax-rate.index');
    }
    public function restore(string $id): RedirectResponse
    {
         try {
            $this->taxRateService->restoreTaxRate($id);
            session()->flash('success', 'Tax rate restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Tax rate restore failed!');
            throw $e;
        }
        return redirect()->route('pm.tax-rate.recycle-bin');
    }

    public function permanentDelete(string $id): RedirectResponse
    {
        try {
            $this->taxRateService->permanentDeleteTaxRate($id);
            session()->flash('success', 'Tax rate permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Tax rate permanent delete failed!');
            throw $e;
        }
        return redirect()->route('pm.tax-rate.recycle-bin');
    }
}
