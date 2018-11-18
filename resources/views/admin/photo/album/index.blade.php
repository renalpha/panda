@extends('layouts.app')

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

                                <div id="progress">
                                    <div class="bar" style="width: 0%;"></div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            @if(count($albums) > 0)
                                @foreach($albums as $album)
                                    <div class="card">
                                        <a href="{{ route('admin.album.index', ['album' => $album->label]) }}">
                                            <img data-src="{{ $album->cover }}" alt="100%x280" style="height: 280px; width: 100%; display: block;" src="{{ asset($album->cover) }}"
                                                 data-holder-rendered="true">
                                        </a>
                                        <p class="card-text">{{ $album->name }}</p>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="row">
                            @if(isset($photos) && count($photos) > 0)
                                @foreach($photos as $photo)
                                    <div class="card">
                                        <a href="{{ $photo->getPhoto() }}" data-lightbox="image-1" data-title="My caption">
                                            <img data-src="{{ $photo->getPhoto(360) }}" alt="100%x280" style=" display: block;" src="{{ $photo->getPhoto(180) }}"
                                                 data-holder-rendered="true">
                                        </a>
                                        <p class="card-text">{{ $album->name }}</p>
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
                            $.each(data.result.files, function (index, file) {
                                $('<p/>').text(file.name).appendTo(document.body);
                            });
                        }
                    });
                });
            </script>
    @endpush
