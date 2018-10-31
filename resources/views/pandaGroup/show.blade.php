@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/group/index">Group</a></li>
    <li class="breadcrumb-item"><a href="/group/{{ $group->label }}">{{ $group->name }}</a></li>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Latest Activities</div>

                    <div class="card-body">
                        No activity
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p></p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Panda Group: {{ $group->name }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <p>You are {{ auth()->user()->name }}</p>
                        <table class="table table-bordered" id="members-table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Points</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#members-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('ajax.group.members', [$group->label]) !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'points', name: 'points'}
                ]
            });
        });
    </script>
@endpush
