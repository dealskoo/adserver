@extends('admin::layouts.panel')

@section('title',__('adserver::adserver.view_ad_space'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('adserver::adserver.view_ad_space') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('adserver::adserver.view_ad_space') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="code" class="form-label">{{ __('adserver::adserver.code') }}</label>
                            <input type="text" class="form-control" id="code" name="code" readonly
                                   value="{{ old('code',$ad_space->code) }}"
                                   placeholder="{{ __('adserver::adserver.code_placeholder') }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description"
                                   class="form-label">{{ __('adserver::adserver.description') }}</label>
                            <textarea class="form-control" id="description" name="description" readonly
                                      rows="5">{{ old('description',$ad_space->description) }}</textarea>
                        </div>
                    </div> <!-- end row -->
                </div>
            </div>
        </div>
    </div>
@endsection
