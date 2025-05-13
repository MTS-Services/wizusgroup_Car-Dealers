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


class DocumentationController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:documentation-list', ['only' => ['index']]);
        $this->middleware('permission:documentation-details', ['only' => ['show']]);
        $this->middleware('permission:documentation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:documentation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:documentation-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = Documentation::with(['creater_admin'])
            ->orderBy('sort_order', 'asc')
            ->latest();
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
        $validated = $request->validated();
        $validated['created_by'] = admin()->id;
        Documentation::create($validated);
        session()->flash('success', 'Documentation created successfully!');
        return redirect()->route('documentation.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $data = Documentation::with(['creater_admin', 'updater_admin'])->findOrFail(decrypt($id));
        $data->documenatation = html_entity_decode($data->documentation);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $data['doc'] = Documentation::findOrFail(decrypt($id));
        return view('backend.admin.documentation.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DocumentationRequest $request, string $id): RedirectResponse
    {
        $doc = Documentation::findOrFail(decrypt($id));
        $validated = $request->validated();
        $validated['updated_by'] = admin()->id;
        $doc->update($validated);
        session()->flash('success', 'Documentation updated successfully!');
        return redirect()->route('documentation.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $doc = Documentation::findOrFail(decrypt($id));
        $doc->update(['deleted_by' => admin()->id]);
        $doc->delete();
        session()->flash('success', 'Documentation deleted successfully!');
        return redirect()->route('documentation.index');
    }
}
