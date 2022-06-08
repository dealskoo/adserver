@extends('admin::layouts.panel')

@section('title', __('adserver::adserver.view_ad'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('adserver::adserver.view_ad') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('adserver::adserver.view_ad') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="cover-box">
                                        <img src="{{ $ad->banner_url }}" class="img-thumbnail file-pic file-cover">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="title" class="form-label">{{ __('adserver::adserver.title') }}</label>
                                    <input type="text" class="form-control" id="title" name="title" readonly
                                        value="{{ $ad->title }}" autofocus tabindex="1">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="link" class="form-label">{{ __('adserver::adserver.link') }}</label>
                                    <input type="text" class="form-control" id="link" name="link" readonly
                                        value="{{ $ad->link }}" tabindex="2">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="country_id"
                                        class="form-label">{{ __('adserver::adserver.country') }}</label>
                                    <input type="text" class="form-control" id="country_id" name="country_id" readonly
                                        value="{{ $ad->country->name }}" tabindex="3">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ad_space_id"
                                        class="form-label">{{ __('adserver::adserver.ad_space') }}</label>
                                    <input type="text" class="form-control" id="ad_space_id" name="ad_space_id" readonly
                                        value="{{ $ad->ad_space->code }}" tabindex="4">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="activity_date"
                                        class="form-label">{{ __('adserver::adserver.start_at') }}
                                        - {{ __('adserver::adserver.end_at') }}</label>
                                    <input type="text" class="form-control date" id="activity_date" name="activity_date"
                                        value="{{ $ad->start_at->format('m/d/Y') . ' - ' . $ad->end_at->format('m/d/Y') }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>
@endsection
