<a href="/ajax/like/type/{{ $likeType }}/id/{{$likeId}}" class="btn-like btn-counter"
   data-placement="bottom" data-count="{{ $likeObject->likesCount ?? 0 }}" data-html="true"
   data-toggle="tooltip"
   title="
<ul>
    @if($likeObject->likes_users)
   @foreach($likeObject->likes_users as $user)
   {{ $user->name }}
   @endforeach
   @endif
           </ul>"
><i class="fa fa-heart"></i></a>