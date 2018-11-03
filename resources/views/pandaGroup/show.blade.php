@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/group/index">Group</a></li>
    <li class="breadcrumb-item">{{ $group->name }}</li>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Latest Activities</div>

                    <div class="card-body">
                        <ul class="list-group" id="activites">
                            @foreach($group->notifications()->take(10)->get() as $notification)
                                <li>
                                    <div href="#" class="list-group-item">
                                        <span class="name" style="min-width: 120px; display: inline-block;">{{ $notification->data['name'] }}</span>
                                        <span class="text-muted" style="font-size: 11px;">{{ $notification->data['message'] }}</span>
                                        <span class="float-right"><span class="badge">{{ $notification->created_at->format('d F Y') }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
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
                        @include('layouts.partials._status_messages')

                        <p><strong>Invitation code:</strong>
                            <Code class=" language-php">{{ route('group.invite',['label' => $group->label, 'code' => $group->uuid]) }}</Code>
                        </p>
                        <hr/>

                        <table class="table table-bordered" id="members-table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Points</th>
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
            $('#members-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('ajax.group.members', [$group->label]) !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'points', name: 'points'},
                    {data: 'manage', name: 'manage'}
                ]
            });
        });
    </script>
@endpush
