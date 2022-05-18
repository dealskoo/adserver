@extends('admin::layouts.panel')

@section('title',__('adserver::adserver.edit_ad_space'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('adserver::adserver.edit_ad_space') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('adserver::adserver.edit_ad_space') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.ad_spaces.update',$ad_space) }}" method="post">
                        @csrf
                        @method('PUT')
                        @if(!empty(session('success')))
                            <div class="alert alert-success">
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        @endif
                        @if(!empty($errors->all()))
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="code" class="form-label">{{ __('adserver::adserver.code') }}</label>
                                <input type="text" class="form-control" id="code" name="code" required
                                       value="{{ old('code',$ad_space->code) }}" autofocus tabindex="1"
                                       placeholder="{{ __('adserver::adserver.code_placeholder') }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description"
                                       class="form-label">{{ __('adserver::adserver.description') }}</label>
                                <textarea class="form-control" id="description" name="description" tabindex="2"
                                          rows="5">{{ old('description',$ad_space->description) }}</textarea>
                            </div>
                        </div> <!-- end row -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-success mt-2" tabindex="3"><i
                                    class="mdi mdi-content-save"></i> {{ __('admin::admin.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
