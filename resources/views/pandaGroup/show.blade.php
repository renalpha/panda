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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @include('layouts.partials._status_messages')
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9"><strong>Invitation code:</strong><br/>
                                <Code class=" language-php"> <a href="#" class="copy-link"
                                                                data-link="{{ route('group.invite',['label' => $group->label, 'code' => $group->uuid]).'?referral_user_id='.auth()->user()->encrypted_user_id }}">{{ route('group.invite',['label' => $group->label, 'code' => $group->uuid]).'?referral_user_id='.auth()->user()->encrypted_user_id }}</a></Code>
                                <input type="hidden" class="copy-link-value"
                                       value="{{ route('group.invite',['label' => $group->label, 'code' => $group->uuid]).'?referral_user_id='.auth()->user()->encrypted_user_id }}"/>
                            </div>
                            <div class="col-md-3">
                                <a href="/ajax/reset/points" class="btn btn-success float-right" onclick="return confirm('Are you sure?')">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Latest Activities</div>

                    <div class="card-body">
                        <ul class="list-group" id="activites">
                            @foreach($group->notifications()->take(10)->get() as $notification)
                                <li>
                                    <div class="list-group-item">
                                        @include('pandaLike.like', [
                                        'likeObject' => $notification,
                                        'likeId' => $notification->id,
                                        'likeType' => 'groupNotification'
                                        ])
                                        <span class="name" style="min-width: 120px; display: inline-block;">{{ $notification->data['message'] }}</span>

                                        <span class="float-right"><span class="badge">{{ $notification->created_at->diffForHumans() }}</span></span>
                                        <hr/>
                                        @include('pandaComments.comments', ['commentsObject' => $notification])
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
                        <table class="table table-bordered display nowrap" id="members-table" style="width:100%">
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
                scrollX: true,
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

@push('headerScripts')
    @if(!auth()->guest())
        <script>
            window.Laravel.groupId = <?php echo $group->id; ?>;
        </script>
    @endif
@endpush
