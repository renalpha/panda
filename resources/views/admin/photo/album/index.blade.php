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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Photo Albums</div>

                    <div class="card-body">
                        @include('layouts.partials._status_messages')

                        <h4 class="float-left">Album</h4>

                        <a href="{{ route('admin.album.new') }}" class="btn btn-primary float-right">Create Album</a>
                        <div class="clearfix"></div>

                        <hr/>
                        @if(isset($album))
                            <p><strong>Upload photos</strong></p>
                            <div class="form-group">
                                <input id="fileupload" type="file" name="files[]" data-url="{{ route('admin.photo.upload') }}" multiple>

                                <div id="uploadStatus"></div>

                                <div id="progress">
                                    <div class="bar" style="width: 0%;"></div>
                                </div>

                            </div>
                        @endif

                        <div class="row">
                            @if(count($subAlbums) > 0)
                                @foreach($subAlbums as $subAlbum)
                                    <div class="card">
                                        <a href="{{ route('admin.album.remove', ['id' => $subAlbum->id]) }}" class="btn btn-sm btn-danger float-right position-absolute" onclick="return confirm('Delete album and childalbums and all pictures?')" data-placement="top" data-toggle="tooltip" title="Delete album"><i class="fa fa-remove"></i></a>
                                        <a href="{{ route('admin.album.index', ['album' => $subAlbum->label]) }}">
                                            <img data-src="{{ $subAlbum->cover }}" alt="100%x280" style="height: 280px; width: 100%; display: block;" src="{{ asset($subAlbum->cover) }}"
                                                 data-holder-rendered="true">
                                        </a>
                                        <p class="card-text">{{ $subAlbum->name }}</p>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="row">
                            @if(isset($photos) && count($photos) > 0)
                                @foreach($photos as $photo)
                                    <div class="card">
                                        <a href="{{ route('admin.photo.remove', ['id' => $photo->id]) }}" class="btn btn-sm btn-danger float-right position-absolute" onclick="return confirm('Are you sure?')" data-placement="bottom" data-toggle="tooltip" title="Delete photo"><i class="fa fa-remove"></i></a>
                                        <a href="{{ $photo->getPhoto() }}" data-lightbox="image-1" data-title="My caption">
                                            <img data-src="{{ $photo->getPhoto(360) }}" alt="100%x280" style="max-height: 100px; display: block;" src="{{ $photo->getPhoto(180) }}"
                                                 data-holder-rendered="true">
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @push('scripts')
            <script>
                $(function () {
                    $('#fileupload').fileupload({
                        formData: {album_id: {{ $album->id ?? null }}},
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
                            location.reload();
                        }
                    });
                });
            </script>
    @endpush
