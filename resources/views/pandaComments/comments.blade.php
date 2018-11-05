<div class="detailBox">
    <div class="actionBox">
        <ul class="commentList">
            @if(isset($commentsObject->comments))
                @foreach($commentsObject->comments()->limit(30)->get() as $comment)
                    <li>
                        <div class="commenterImage">
                            <img src="{{ $comment->profile_picture ?? '/images/placeholder_profile.png' }}" alt="User" />
                        </div>
                        <div class="commentText">
                            <p><strong>{{ $comment->name }}</strong></p>
                            <p>{{ $comment->comment }}</p>
                            <span class="date sub-text">on {{ $comment->created_at->diffForHumans() }} |
                                @include('pandaLike.like', [
                                'likeObject' => $comment,
                                'likeId' => $comment->id,
                                'likeType' => 'pandaComment'
                                ])
                            </span>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
        <form class="form-inline replyForm" role="form" method="post" action="{{ route('comment.store', ['type' => 'groupNotification', 'id' => $commentsObject->id]) }}">
            @csrf
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Your comments" name="comment" />
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Post</button>
            </div>
        </form>
    </div>
</div>
