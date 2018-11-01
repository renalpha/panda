@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/group/index">Group</a></li>
    <li class="breadcrumb-item">{{ $group->name }}</li>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $group->name }}</div>

                    <div class="card-body">
                        @include('layouts.partials._status_messages')
                        <hr/>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection