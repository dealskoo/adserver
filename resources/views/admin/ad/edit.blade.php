@extends('admin::layouts.panel')

@section('title', __('adserver::adserver.edit_ad'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('adserver::adserver.edit_ad') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('adserver::adserver.edit_ad') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.ads.update', $ad) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @if (!empty(session('success')))
                            <div class="alert alert-success">
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        @endif
                        @if (!empty($errors->all()))
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="cover-box">
                                            <img src="{{ $ad->banner_url }}" class="img-thumbnail file-pic file-cover">
                                            <div class="upload-image">
                                                <i class="mdi mdi-cloud-upload upload-btn upload-cover-btn"></i>
                                                <input class="file-input" name="banner" tabindex="6" type="file"
                                                    accept="image/*" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="title"
                                            class="form-label">{{ __('adserver::adserver.title') }}</label>
                                        <input type="text" class="form-control" id="title" name="title" required
                                            value="{{ old('title', $ad->title) }}" autofocus tabindex="1"
                                            placeholder="{{ __('adserver::adserver.title_placeholder') }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="link"
                                            class="form-label">{{ __('adserver::adserver.link') }}</label>
                                        <input type="text" class="form-control" id="link" name="link" required
                                            value="{{ old('link', $ad->link) }}" tabindex="2"
                                            placeholder="{{ __('adserver::adserver.link_placeholder') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="country_id"
                                            class="form-label">{{ __('adserver::adserver.country') }}</label>
                                        <select id="country_id" name="country_id" class="form-control select2"
                                            data-toggle="select2" tabindex="3" required>
                                            @foreach ($countries as $country)
                                                @if ($ad->country_id == $country->id)
                                                    <option value="{{ $country->id }}" selected>{{ $country->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="ad_space_id"
                                            class="form-label">{{ __('adserver::adserver.ad_space') }}</label>
                                        <select id="ad_space_id" name="ad_space_id" class="form-control select2"
                                            data-toggle="select2" tabindex="4" required>
                                            @foreach ($ad_spaces as $ad_space)
                                                @if ($ad->ad_space_id == $ad_space->id)
                                                    <option value="{{ $ad_space->id }}" selected>{{ $ad_space->code }}
                                                    </option>
                                                @else
                                                    <option value="{{ $ad_space->id }}">{{ $ad_space->code }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="activity_date"
                                            class="form-label">{{ __('adserver::adserver.start_at') }}
                                            - {{ __('adserver::adserver.end_at') }}</label>
                                        <input type="text" class="form-control date" id="activity_date" name="activity_date"
                                            data-toggle="date-picker"
                                            value="{{ old('activity_date', $ad->start_at->format('m/d/Y') . ' - ' . $ad->end_at->format('m/d/Y')) }}"
                                            required tabindex="5">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-success mt-2" tabindex="7"><i
                                    class="mdi mdi-content-save"></i> {{ __('admin::admin.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
