<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DocumentationRequest;
use App\Models\Documentation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Services\Admin\DocumentationService;

class DocumentationController extends Controller
{
    use DetailsCommonDataTrait;
    protected DocumentationService $documentationService;
    public function __construct(DocumentationService $documentationService)
    {
        $this->documentationService = $documentationService;

        $this->middleware('auth:admin');
        $this->middleware('permission:documentation-list', ['only' => ['index']]);
        $this->middleware('permission:documentation-details', ['only' => ['show']]);
        $this->middleware('permission:documentation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:documentation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:documentation-delete', ['only' => ['destroy']]);
        $this->middleware('permission:documentation-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:documentation-restore', ['only' => ['restore']]);
        $this->middleware('permission:documentation-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
           $query = $this->documentationService->getDocumentations()->with(['creater_admin']);
            return DataTables::eloquent($query)

                ->editColumn('created_at', function ($doc) {
                    return $doc->created_at_formatted;
                })
                ->editColumn('created_by', function ($doc) {
                    return $doc->creater_name;
                })
                ->editColumn('action', function ($doc) {
                    $menuItems = $this->menuItems($doc);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['created_at', 'created_by', 'action'])
                ->make(true);
        }
        return view('backend.admin.documentation.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['documentation-details']
            ],
            [
                'routeName' => 'documentation.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['documentation-edit']
            ],

            [
                'routeName' => 'documentation.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['documentation-delete']
            ]

        ];
    }

        public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->documentationService->getDocumentations()->onlyTrashed()->with(['deleter_admin']);
            return DataTables::eloquent($query)
                ->editColumn('deleted_by', function ($doc) {
                    return $doc->deleter_name;
                })
                ->editColumn('deleted_at', function ($doc) {
                    return $doc->deleted_at_formatted;
                })
                ->editColumn('action', function ($doc) {
                    $menuItems = $this->trashedMenuItems($doc);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns([ 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.documentation..recycle-bin');
    }
    /**
     * Define menu items for trashed items in admin list.
     *
     * @param Admin $model
     * @return array
     */
    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'documentation.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['admin-restore']
            ],
            [
                'routeName' => 'documentation.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['documentation-permanent-delete']
            ]

        ];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.admin.documentation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DocumentationRequest $request): RedirectResponse
    {
         try {
            $validated = $request->validated();
            $this->documentationService->createDocumentation($validated);
            session()->flash('success', 'Documentation created successfully!');
        } catch (\Throwable $e) {
            session()->flash('success', 'Documentation created successfully!');
            throw $e;
        }
        return redirect()->route('documentation.index');
    }

    /**
     * Display the specified resource.
     */
     public function show(string $id): JsonResponse
    {
        $data = $this->documentationService->getDocumentation($id);
        $data->load(['creater_admin', 'updater_admin']);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $data['doc'] = $this->documentationService->getDocumentation($id);
        return view('backend.admin.documentation.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DocumentationRequest $request, string $id): RedirectResponse
    {
        try {
            $doc = $this->documentationService->getDocumentation($id);
            $validated = $request->validated();
            $this->documentationService->updateDocumentation($doc,$validated);
            session()->flash('success', 'Documentation updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Documentation update failed!');
            throw $e;
        }
        return redirect()->route('documentation.index');
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(string $id): RedirectResponse
    {
        $doc = $this->documentationService->getDocumentation($id);
        $this->documentationService->delete( $doc);
        session()->flash('success', 'Documentation move to recycle bin successfully!');
        return redirect()->route('documentation.index');
    }
      public function restore(string $id): RedirectResponse
    {
        $this->documentationService->restore( $id );
        session()->flash('success', 'Documentation restored successfully!');
        return redirect()->route('documentation.recycle-bin');
    }

    /**
     * Remove the specified resource from storage permanently.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function permanentDelete(string $id): RedirectResponse
    {
       $this->documentationService->permanentDelete( $id );
        session()->flash('success', 'Documentation permanently deleted successfully!');
        return redirect()->route('documentation.recycle-bin');
    }
}
