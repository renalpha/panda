@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/group/index">Group</a></li>
    <li class="breadcrumb-item"><a href="/group/{{ $group->label }}">{{ $group->name }}</a></li>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Update group: {{ $group->name }}</div>

                    <div class="card-body">
                        @include('layouts.partials._status_messages')

                        <p>You are {{ auth()->user()->name }}</p>
                            <hr/>
                            <form method="post" action="{{ route('group.edit.store',['id' => $group->id]) }}">
                                @include('pandaGroup.partials._form')
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection