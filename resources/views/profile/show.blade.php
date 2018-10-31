@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/profile">Profile</a></li>
    <li class="breadcrumb-item"><a href="/profile">{{ $profile->name }}</a></li>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Profile</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are {{ $profile->name }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
