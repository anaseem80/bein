@extends('front.layout.layout')
@section('title', isset($title) ? $title : '')
@section('variables')
    @php($is_preview = isset($preview))
@endsection
@section('page_css')
    <style>
        .error {
            color: red;
        }

    </style>
@endsection
@section('content')
    <div class="py-5 scrolling">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 article-main-container">
                    <h1 class="text-center mb-3">{{ $article->name }}</h1>
                    <img width="100%" src="{{ asset($article->image) }}" alt="">
                    <div class="d-flex justify-content-between flex-wrap my-4 article-info">
                        <div><i class="fa fa-clock"></i>
                            <span dir="ltr">
                                {{ $article->created_at->translatedFormat('Y ,d F') }}
                            </span>
                        </div>
                        <div><i class="fa fa-user"></i> <a href="#"
                                class="main-color-yellow-hover text-decoration-none text-success">{{ $article->user->name }}</a>
                        </div>
                        <div>{!! isset($article->lastComment[0]->comment) ? '<i class="fa fa-comment"></i> ' . $article->lastComment[0]->comment : '' !!}</div>
                        <div><i class="fa fa-file"></i>
                            @if (count($article->categories) == 0)
                                Uncategorized
                            @else
                                @foreach ($article->categories as $category)
                                    <?= !$loop->first ? ', ' . $category->name : $category->name ?>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="mt-3">{!! $article->content !!}</div>

                    <hr>
                    <div @class([
                        'product-comment',
                        'item-preview' => isset($preview),
                    ])>
                     <x-comments :item="$article" type="blogs"/>
                    </div>
                </div>
                @include('front.layout.comments-latestarticles')

            </div>
        </div>
    </div>
@endsection
@section('page_js')
    @if (!isset($preview))
   <script src="{{ asset('resources/assets/js/jquery.validate.min.js') }}"></script>
   <script src="{{ asset('resources/assets/js/content/add_comment.js') }}"></script>
   <script src="{{ asset('resources/assets/js/content/remove.js') }}"></script>
    @endif
@endsection
