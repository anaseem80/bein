<?php 
use App\Http\Controllers\FrontController;
$latestArticles=FrontController::comments_latestArticles('latestArticles');
$comments=FrontController::comments_latestArticles('comments');
?>
<div class="col-lg-4 articles">
    <div class="article-box mb-4 p-4 pb-3">
        <h5 class="py-2 border-5 border-success border-end text-center m-0 bg-light text-success">أحدث
            التعليقات</h5>
        <ul class="list-unstyled p-0 mt-2">
        @foreach ($comments as $comment)
            
            <li class="d-flex justify-content-between align-items-center">
                <a href="{{route($comment->type=='packages'?'product-redirect':'article',$comment->item_id)}}" class="main-color-yellow-hover text-dark">{{Str::limit($comment->comment,30)}}</a>
                <i class="fa fa-chevron-left"></i>
            </li>
        @endforeach
        </ul>
    </div>
    <div class="article-box mb-4 p-4 pb-3">
        <h5 class="py-2 border-5 border-success border-end text-center m-0 bg-light text-success">أحدث
            المقالات</h5>
        <ul class="list-unstyled p-0 mt-2">
            @foreach ($latestArticles as $article)
            <li class="d-flex justify-content-between align-items-center">
                <a href="{{route('article',$article->id)}}" class="main-color-yellow-hover text-dark">{{$article->name}}</a>
                <i class="fa fa-chevron-left"></i>
            </li>
            @endforeach
        </ul>
    </div>
</div>