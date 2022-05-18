<?php

namespace Dealskoo\Adserver\Http\Controllers\Admin;

use Carbon\Carbon;
use Dealskoo\Admin\Http\Controllers\Controller as AdminController;
use Dealskoo\Adserver\Models\AdSpace;
use Illuminate\Http\Request;

class AdSpaceController extends AdminController
{
    public function index(Request $request)
    {
        abort_if(!$request->user()->canDo('ad_spaces.index'), 403);
        if ($request->ajax()) {
            return $this->table($request);
        } else {
            return view('adserver::admin.ad_space.index');
        }
    }

    private function table(Request $request)
    {
        $start = $request->input('start', 0);
        $limit = $request->input('length', 10);
        $keyword = $request->input('search.value');
        $columns = ['id', 'code', 'created_at', 'updated_at'];
        $column = $columns[$request->input('order.0.column', 0)];
        $desc = $request->input('order.0.dir', 'desc');
        $query = AdSpace::query();
        if ($keyword) {
            $query->where('code', 'like', '%' . $keyword . '%');
        }
        $query->orderBy($column, $desc);
        $count = $query->count();
        $ad_spaces = $query->skip($start)->take($limit)->get();
        $rows = [];
        $can_view = $request->user()->canDo('ad_spaces.show');
        $can_edit = $request->user()->canDo('ad_spaces.edit');
        $can_destroy = $request->user()->canDo('ad_spaces.destroy');
        foreach ($ad_spaces as $ad_space) {
            $row = [];
            $row[] = $ad_space->id;
            $row[] = $ad_space->code;
            $row[] = Carbon::parse($ad_space->created_at)->format('Y-m-d H:i:s');
            $row[] = Carbon::parse($ad_space->updated_at)->format('Y-m-d H:i:s');
            $view_link = '';
            if ($can_view) {
                $view_link = '<a href="' . route('admin.ad_spaces.show', $ad_space) . '" class="action-icon"><i class="mdi mdi-eye"></i></a>';
            }

            $edit_link = '';
            if ($can_edit) {
                $edit_link = '<a href="' . route('admin.ad_spaces.edit', $ad_space) . '" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>';
            }
            $destroy_link = '';
            if ($can_destroy) {
                $destroy_link = '<a href="javascript:void(0);" class="action-icon delete-btn" data-table="ad_spaces_table" data-url="' . route('admin.ad_spaces.destroy', $ad_space) . '"> <i class="mdi mdi-delete"></i></a>';
            }
            $row[] = $view_link . $edit_link . $destroy_link;
            $rows[] = $row;
        }
        return [
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $rows
        ];
    }

    public function show(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('ad_spaces.show'), 403);
        $ad_space = AdSpace::query()->findOrFail($id);
        return view('adserver::admin.ad_space.show', ['ad_space' => $ad_space]);
    }

    public function create(Request $request)
    {
        abort_if(!$request->user()->canDo('ad_spaces.create'), 403);
        return view('adserver::admin.ad_space.create');
    }

    public function store(Request $request)
    {
        abort_if(!$request->user()->canDo('ad_spaces.create'), 403);
        $request->validate([
            'code' => ['required', 'string', 'unique:ad_spaces'],
        ]);
        $ad_space = new AdSpace($request->only([
            'code',
            'description'
        ]));
        $ad_space->save();
        return back()->with('success', __('admin::admin.added_success'));
    }

    public function edit(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('ad_spaces.edit'), 403);
        $ad_space = AdSpace::query()->findOrFail($id);
        return view('adserver::admin.ad_space.edit', ['ad_space' => $ad_space]);
    }

    public function update(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('ad_spaces.edit'), 403);
        $request->validate([
            'code' => ['required', 'string', 'unique:ad_spaces' . $id . ',id'],
        ]);

        $ad_space = AdSpace::query()->findOrFail($id);
        $ad_space->fill($request->only([
            'code',
            'description'
        ]));
        $ad_space->save();
        return back()->with('success', __('admin::admin.update_success'));
    }

    public function destroy(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('ad_spaces.destroy'), 403);
        return ['status' => AdSpace::destroy($id)];
    }
}
