@extends('front.layout.layout')
@section('title', isset($title) ? $title : '')
@section('content')
    <div class="py-5 scrolling">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 articles-main-container">
                    @foreach($articles as $article)
                    <div class="article-container border-end border-5 pe-3 text-center">
                        <h1 class="mb-3"><a href="{{route('article',$article->id)}}"
                                class="main-color-yellow-hover text-decoration-none text-success">
                                {{$article->name}}
                            </a></h1>
                        <div class="d-flex justify-content-between flex-wrap my-4 article-info">
                            <div><i class="fa fa-clock"></i> 
                                <span dir="ltr">
                                    {{$article->created_at->translatedFormat('Y ,d F')}}
                                </span>
                            </div>
                            <div><i class="fa fa-user"></i> <a href="#"
                                    class="main-color-yellow-hover text-decoration-none text-success">{{$article->user->name}}</a></div>
                            <div>{!!isset($article->lastComment[0]->comment)?'<i class="fa fa-comment"></i> ' .$article->lastComment[0]->comment:''!!}</div>
                            <div><i class="fa fa-file"></i>
                                @if(count($article->categories)==0)
                                Uncategorized
                                @else
                                @foreach($article->categories as $category)
                                <?=!$loop->first?', '.$category->name:$category->name?>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <p class="my-2">
                            {{strlen(strip_tags($article->content))>300?substr(strip_tags($article->content),0,300).'...':strip_tags($article->content)}}
                        </p>
                        <a href="{{route('article',$article->id)}}"><button class="main-button my-3">
                                <p class="position-relative m-0">قراءة المزيد</p>
                            </button></a>
                    </div>
                    @endforeach
                    <div class="d-flex justify-content-center align-items-center">
                        {{$articles->links('front.layout.pagination')}}
                    </div>
                </div>
                @include('front.layout.comments-latestarticles')
            </div>
        </div>
    </div>
@endsection
