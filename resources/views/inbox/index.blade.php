@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">消息通知</div>
                    <div class="panel-body">
                        @foreach($messages as $dialogId => $messageGroup)
                            <div class="media">
                                <div class="media-left">
                                    @if (Auth::id() == $messageGroup->first()->fromUser->id )
                                        <a href="{{ route('user', ['id' => $messageGroup->first()->fromUser->id]) }}">
                                            <img width="48" src="{{ $messageGroup->first()->fromUser->avatar }}" alt="">
                                        </a>
                                    @else
                                        <a href="{{ route('user', ['id' => $messageGroup->first()->toUser->id]) }}">
                                            <img width="48" src="{{ $messageGroup->first()->toUser->avatar }}" alt="">
                                        </a>
                                    @endif
                                </div>
                                <div class="media-body {{ $messageGroup->first()->shouldAddUnreadClass() ? 'unread' : '' }}">
                                    <h4 class="media-heading">
                                        @if (Auth::id() == $messageGroup->first()->toUser->id)
                                            <a href="{{ route('user', ['id' => $messageGroup->first()->fromUser->id]) }}">
                                                {{ $messageGroup->first()->fromUser->name }}
                                            </a>
                                        @else
                                            <a href="{{ route('user', ['id' => $messageGroup->first()->toUser->id]) }}">
                                                {{ $messageGroup->first()->toUser->name }}
                                            </a>
                                        @endif
                                    </h4>
                                    <p>
                                        <a href="/message/{{ $dialogId }}">
                                            {{ $messageGroup->first()->body }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
