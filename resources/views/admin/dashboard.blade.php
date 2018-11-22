@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item">Dashboard</li>
    @if(isset($album))
        <li class="breadcrumb-item">Dashboard</li>
    @endif
@stop


@section('content')
    <div class="card">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
            @include('layouts.partials._status_messages')
            <h4>Hello {{ auth()->user()->name }}, welcome to your dashboard</h4>
            <p>Here you may organize and manage your settings.</p>
        </div>
    </div>
@endsection

