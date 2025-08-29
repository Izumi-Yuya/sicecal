@extends('layouts.app')

@section('title', '施設詳細')

@section('content')
<div class="container-fluid">
    @include('facilities.partials.header')
    
    <div class="facility-tabs">
        @include('facilities.partials.tabs-nav')

        <!-- Tab Content -->
        <div class="tab-content" id="facilityTabContent">
            @include('facilities.partials.basic-info')
            @include('facilities.partials.land-info')
            @include('facilities.partials.other-tabs')
        </div>
    </div>
</div>

@push('scripts')
    @vite('resources/js/facility-show.js')
@endpush

@endsection