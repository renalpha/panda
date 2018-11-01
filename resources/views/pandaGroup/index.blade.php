@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Groups</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <a href="{{ route('group.new') }}" class="btn btn-primary float-right">Create Group</a>

                        <p>You are {{ auth()->user()->name }}</p>
                        <table class="table table-bordered" id="groups-table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Members</th>
                                <th>Manage</th>
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
            $('#groups-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('ajax.group.index') !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'members', name: 'members', searchable: false},
                    {data: 'manage', name: 'manage'},
                ]
            });
        });
    </script>
@endpush
