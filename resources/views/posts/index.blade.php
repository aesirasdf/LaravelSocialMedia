@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-3">
            <form action="{{ route("posts-store") }}" method="POST">
                @csrf
                <div class="input-group">
                    <textarea class="form-control" name="content" placeholder="What's on your mind?"></textarea>
                    <div class="input-group-append ml-3">
                        <button class="btn btn-primary" style="border-radius: 12px; height: 70px; padding: 20px;">Post</button>
                    </div>
                </div>
            </form>
        </div>
        {{-- POSTS LIST --}}
        <div class="row mt-5">
            @foreach($Posts as $Post)
                <div class="col-lg-4">
                    <div class="card mx-2 mb-2">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title d-inline">{{ $Post->User->name }}</h5>
                                <div class="dropdown d-inline float-right">
                                    <button class="toText" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route("posts-show", ["id" => $Post->id]) }}">Show</a>
                                        @if($Post->user_id == auth()->user()->id)
                                            <a class="dropdown-item posts-edit-button" data-content="{{ $Post->content }}" data-id="{{ $Post->id }}">Edit</a>
                                            <a class="dropdown-item">
                                                <form class="w-100 p-0" action="{{ route("posts-delete", ["id" => $Post->id]) }}" method="POST">
                                                    @csrf
                                                    @method("DELETE")
                                                    <input class="w-100 toText text-left" type="submit" value="Delete">
                                                </form>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <h6 class="card-subtitle mb-2 text-muted">{{ date_format(date_create($Post->created_at), "M d, Y h:iA") }}</h6>
                            <div class="card-text text-truncate" style="max-width:100px">
                                {{ $Post->content }}
                            </div>
                            {{-- <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal" id="posts-update-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="posts-update-form" action="" method="POST">
                        @csrf
                        @method("PATCH")
                        <textarea name="content" id="posts-content-modal" class="form-control" placeholder="What's on your mind?"></textarea>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="posts-update-submit" type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $(".posts-edit-button").on("click", function(){
                $("#posts-content-modal").html($(this).attr("data-content"));
                $("#posts-update-form").attr("action", "/posts/" + $(this).attr("data-id"));
                $("#posts-update-modal").modal("show");
            });

            $("#posts-update-submit").on("click", function(){
                $("#posts-update-form").submit();
            });
        });
    </script>
@endsection

