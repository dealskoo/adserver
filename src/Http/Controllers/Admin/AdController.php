<?php

namespace Dealskoo\Adserver\Http\Controllers\Admin;

use Carbon\Carbon;
use Dealskoo\Admin\Http\Controllers\Controller as AdminController;
use Dealskoo\Adserver\Models\Ad;
use Dealskoo\Adserver\Models\AdSpace;
use Dealskoo\Country\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AdController extends AdminController
{
    public function index(Request $request)
    {
        abort_if(!$request->user()->canDo('ads.index'), 403);
        if ($request->ajax()) {
            return $this->table($request);
        } else {
            return view('adserver::admin.ad.index');
        }
    }

    private function table(Request $request)
    {
        $start = $request->input('start', 0);
        $limit = $request->input('length', 10);
        $keyword = $request->input('search.value');
        $columns = ['id', 'title', 'ad_space_id', 'country_id', 'start_at', 'end_at', 'created_at', 'updated_at'];
        $column = $columns[$request->input('order.0.column', 0)];
        $desc = $request->input('order.0.dir', 'desc');
        $query = Ad::query();
        if ($keyword) {
            $query->where('title', 'like', '%' . $keyword . '%');
        }
        $query->orderBy($column, $desc);
        $count = $query->count();
        $ads = $query->skip($start)->take($limit)->get();
        $rows = [];
        $can_view = $request->user()->canDo('ads.show');
        $can_edit = $request->user()->canDo('ads.edit');
        $can_destroy = $request->user()->canDo('ads.destroy');
        foreach ($ads as $ad) {
            $row = [];
            $row[] = $ad->id;
            $row[] = $ad->title;
            $row[] = $ad->ad_space->code;
            $row[] = $ad->country->name;
            $row[] = Carbon::parse($ad->start_at)->format('Y-m-d H:i:s');
            $row[] = Carbon::parse($ad->end_at)->format('Y-m-d H:i:s');
            $row[] = Carbon::parse($ad->created_at)->format('Y-m-d H:i:s');
            $row[] = Carbon::parse($ad->updated_at)->format('Y-m-d H:i:s');
            $view_link = '';
            if ($can_view) {
                $view_link = '<a href="' . route('admin.ads.show', $ad) . '" class="action-icon"><i class="mdi mdi-eye"></i></a>';
            }

            $edit_link = '';
            if ($can_edit) {
                $edit_link = '<a href="' . route('admin.ads.edit', $ad) . '" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>';
            }
            $destroy_link = '';
            if ($can_destroy) {
                $destroy_link = '<a href="javascript:void(0);" class="action-icon delete-btn" data-table="ads_table" data-url="' . route('admin.ads.destroy', $ad) . '"> <i class="mdi mdi-delete"></i></a>';
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
        abort_if(!$request->user()->canDo('ads.show'), 403);
        $ad = Ad::query()->findOrFail($id);
        return view('adserver::admin.ad.show', ['ad' => $ad]);
    }

    public function create(Request $request)
    {
        abort_if(!$request->user()->canDo('ads.create'), 403);
        $countries = Country::all();
        $ad_spaces = AdSpace::all();
        return view('adserver::admin.ad.create', ['countries' => $countries, 'ad_spaces' => $ad_spaces]);
    }

    public function store(Request $request)
    {
        abort_if(!$request->user()->canDo('ads.create'), 403);
        $request->validate([
            'title' => ['required', 'string'],
            'link' => ['required', 'url'],
            'country_id' => ['required', 'exists:countries,id'],
            'ad_space_id' => ['required', 'exists:ad_spaces,id'],
            'banner' => ['required', 'image', 'max:1000'],
            'activity_date' => ['required', 'string']
        ]);
        $between = explode(' - ', $request->input('activity_date'));
        $start = date('Y-m-d', strtotime($between[0]));
        $end = date('Y-m-d', strtotime($between[1]));
        $image = $request->file('banner');
        $filename = time() . '.' . $image->guessExtension();
        $path = $image->storeAs('adserver/images/' . date('Ymd'), $filename);
        $ad = new Ad(Arr::collapse([$request->only([
            'title', 'link', 'country_id', 'ad_space_id'
        ]), ['banner' => $path, 'start_at' => $start, 'end_at' => $end]]));
        $ad->save();
        return back()->with('success', __('admin::admin.added_success'));
    }

    public function edit(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('ads.edit'), 403);
        $countries = Country::all();
        $ad_spaces = AdSpace::all();
        $ad = Ad::query()->findOrFail($id);
        return view('adserver::admin.ad.edit', ['countries' => $countries, 'ad_spaces' => $ad_spaces, 'ad' => $ad]);
    }

    public function update(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('ads.edit'), 403);
        if ($request->hasFile('banner')) {
            $request->validate([
                'title' => ['required', 'string'],
                'link' => ['required', 'url'],
                'country_id' => ['required', 'exists:countries,id'],
                'ad_space_id' => ['required', 'exists:ad_spaces,id'],
                'banner' => ['required', 'image', 'max:1000'],
                'activity_date' => ['required', 'string']
            ]);
        } else {
            $request->validate([
                'title' => ['required', 'string'],
                'link' => ['required', 'url'],
                'country_id' => ['required', 'exists:countries,id'],
                'ad_space_id' => ['required', 'exists:ad_spaces,id'],
                'activity_date' => ['required', 'string']
            ]);
        }
        $between = explode(' - ', $request->input('activity_date'));
        $start = date('Y-m-d', strtotime($between[0]));
        $end = date('Y-m-d', strtotime($between[1]));
        $ad = Ad::query()->findOrFail($id);
        $ad->fill(Arr::collapse([$request->only([
            'title', 'link', 'country_id', 'ad_space_id'
        ]), ['start_at' => $start, 'end_at' => $end]]));
        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $filename = time() . '.' . $image->guessExtension();
            $path = $image->storeAs('adserver/images/' . date('Ymd'), $filename);
            $ad->banner = $path;
        }
        $ad->save();
        return back()->with('success', __('admin::admin.update_success'));
    }

    public function destroy(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('ads.destroy'), 403);
        return ['status' => Ad::destroy($id)];
    }
}
