@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create new Group</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <p>You are {{ auth()->user()->name }}</p>
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