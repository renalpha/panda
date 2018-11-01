@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/group/index">Group</a></li>
    <li class="breadcrumb-item"><a href="/group/create">Create new</a></li>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create new Group</div>

                    <div class="card-body">
                        @include('layouts.partials._status_messages')

                        <hr/>
                        <form method="post" action="{{ route('group.new.store') }}">
                            @include('pandaGroup.partials._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection