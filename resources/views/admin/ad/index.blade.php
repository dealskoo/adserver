@extends('admin::layouts.panel')
@section('title',__('adserver::adserver.ads_list'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('adserver::adserver.ads_list') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('adserver::adserver.ads_list') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(Auth::user()->canDo('ads.create'))
                        <div class="row mb-2">
                            <div class="col-12">
                                <a href="{{ route('admin.ads.create') }}" class="btn btn-danger mb-2"><i
                                        class="mdi mdi-plus-circle me-2"></i> {{ __('adserver::adserver.add_ad') }}
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="ads_table" class="table table-centered w-100 dt-responsive nowrap">
                            <thead class="table-light">
                            <tr>
                                <th>{{ __('adserver::adserver.id') }}</th>
                                <th>{{ __('adserver::adserver.title') }}</th>
                                <th>{{ __('adserver::adserver.ad_space') }}</th>
                                <th>{{ __('adserver::adserver.country') }}</th>
                                <th>{{ __('adserver::adserver.start_at') }}</th>
                                <th>{{ __('adserver::adserver.end_at') }}</th>
                                <th>{{ __('adserver::adserver.created_at') }}</th>
                                <th>{{ __('adserver::adserver.updated_at') }}</th>
                                <th>{{ __('adserver::adserver.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            let table = $('#ads_table').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('admin.ads.index') }}",
                "language": language,
                "pageLength": pageLength,
                "columns": [
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': false},
                ],
                "order": [[0, "desc"]],
                "drawCallback": function () {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                    $('#ads_table tr td:nth-child(9)').addClass('table-action');
                    delete_listener();
                }
            });

            table.on('childRow.dt', function (e, row) {
                delete_listener();
            });
        });
    </script>
@endsection
