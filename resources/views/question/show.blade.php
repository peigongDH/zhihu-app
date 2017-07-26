@extends('layouts.app')
@include('vendor.ueditor.assets')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $question->title }}
                        @foreach($question->topics as $topic)
                            <a class="topic pull-right" href="/topic/{{ $topic->id }}">{{ $topic->name }}</a>
                        @endforeach
                    </div>
                    <div class="panel-body content">
                        {!! $question->body !!}
                    </div>
                    <div class="actions">
                        @if(Auth::check() && Auth::user()->owns($question))
                            <span class="edit"><a href="/question/{{ $question->id }}/edit">编辑</a></span>
                            <form action="/question/{{ $question->id }}" method="POST" class="delete-form">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="button delete-button is-naked">删除</button>
                            </form>
                        @endif
                        <comment type="question"
                                 model="{{ $question->id }}"
                                 count="{{ $question->comments()->count() }}">
                        </comment>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h2>{{ $question->followers_count }}</h2>
                        <span>关注者</span>
                    </div>
                    <div class="panel-body">
                        <question-follow-button is_login="{{ Auth::check() }}"
                                                question="{{ $question->id }}"></question-follow-button>
                        <a href="#editor" class="btn btn-primary pull-right">撰写答案</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $question->answers_count }} 个答案
                    </div>
                    <div class="panel-body">

                        @foreach($question->answers as $answer)
                            <div class="media">
                                <div class="media-left">
                                    {{--<a href="/user/{{ $answer->user->id }}">--}}
                                    {{--<img width="36" src="{{ $answer->user->avatar }}"--}}
                                    {{--alt="{{ $answer->user->name }}">--}}
                                    {{--</a>--}}
                                    <user-vote-button answer="{{ $answer->id }}"
                                                      count="{{ $answer->votes_count }}"></user-vote-button>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="/user/{{ $answer->user->id }}">
                                            {{ $answer->user->name }}
                                        </a>
                                    </h4>
                                    {!! $answer->body !!}
                                </div>
                                <comment type="answer"
                                         model="{{ $answer->id }}"
                                         count="{{ $answer->comments->count() }}">
                                </comment>
                            </div>
                        @endforeach

                        @if(Auth::check())
                            <form action="/question/{{ $question->id }}/answer" method="post">
                            {!! csrf_field() !!}
                            <!-- 编辑器容器 -->
                                <div class="form-group {{ $errors->has('body') ? ' has-error' : '' }}">
                                    <script id="container" name="body" type="text/plain">
                                        {!! old('body') !!}
                                    </script>
                                    @if ($errors->has('body'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                    @endif
                                    <button class="btn btn-primary pull-right" type="submit">提交答案</button>
                                </div>
                            </form>
                        @else
                            <a href="{{ url('login') }}" class="btn btn-primary btn-block">登录提交答案</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h5>关于作者</h5>
                    </div>
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img width="36" src="{{ $question->user->avatar }}"
                                         alt="{{ $question->user->name }}">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="#">
                                        {{ $question->user->name }}
                                    </a>
                                </h4>
                            </div>
                            <div class="user-statics">
                                <div class="statics-item text-center">
                                    <div class="statics-text">问题</div>
                                    <div class="statics-count">{{ $question->user->questions_count }}</div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">回答</div>
                                    <div class="statics-count">{{ $question->user->answers_count }}</div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">关注者</div>
                                    <div class="statics-count">{{ $question->user->followers_count }}</div>
                                </div>
                            </div>
                        </div>
                        <user-follow-button is_login="{{ Auth::check() }}"
                                            user="{{ $question->user_id }}"></user-follow-button>
                        <send-message is_login="{{ Auth::check() }}" user="{{ $question->user_id }}"></send-message>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('js')
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
                @if (Auth::check())
        var ue = UE.getEditor('container');
        ue.ready(function () {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
        @endif

    </script>
@endsection
@endsection
