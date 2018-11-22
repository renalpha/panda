@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/admin/photo/album">Photos</a></li>
    @if(isset($album))
        @foreach($album->allChildren as $child)
            <li class="breadcrumb-item"><a href="/admin/photo/album/{{ $child->label }}">{{ $child->name }}</a></li>
        @endforeach
        <li class="breadcrumb-item">{{ $album->name }}</li>
    @endif
@stop


@section('content')
    <div class="card">
        <div class="card-header">Photo Albums</div>

        <div class="card-body">
            @include('layouts.partials._status_messages')

            <a href="{{ route('admin.album.new') }}" class="btn btn-primary float-right">Create Album</a>
            <div class="clearfix"></div>

            <hr/>
            <input id="fileupload" type="file" name="files[]" data-url="{{ route('admin.photo.upload') }}" multiple>

            <div id="progress">
                <div class="bar" style="width: 0%;"></div>
            </div>

            <a href="/images/placeholder_profile.png" data-lightbox="image-1" data-title="My caption">Image #1</a>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#fileupload').fileupload({
                dataType: 'json',
                beforeSend: function (xhr, data) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .bar').css(
                        'width',
                        progress + '%'
                    );
                },
                done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        $('<p/>').text(file.name).appendTo(document.body);
                    });
                }
            });
        });
    </script>
@endpush
