   <div>
       <form id="add-form">
           <h1>اترك تعليقا!</h1>
           <div class="form-group">
               <label for="comment">التعليق <img
                       src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}" width="25px"
                       alt=""></label>
               <textarea name="comment" id="comment" class="form-control" cols="30" rows="10"></textarea>
           </div>
           <div class="form-group mt-4">
               <label for="fname">الاسم<img src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}"
                       width="25px" alt=""></label>
               <input type="text" name="name" id="name" class="form-control" placeholder="مثال"
                   value="{{ isset($user) ? $user->name : '' }}">
           </div>
           <div class="form-group mt-4">
               <label for="email">البريد الإلكتروني<img
                       src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}" width="25px"
                       alt=""></label>
               <input type="email" name="email" id="email" class="form-control" placeholder="مثال@مثال"
                   value="{{ isset($user) ? $user->email : '' }}">
           </div>
           <button class="main-button my-3 w-100" id="add-comment" data-type="{{ $type }}"
               data-id="{{ $item->id }}">
               <p class="position-relative m-0">إرسال</p>
           </button>
       </form>
   </div>
   <div class="mt-3">
       <hr>
       <h2>التعليقات</h2>
       <div class="row" id="comment-container">
           @foreach ($item->comments as $comment)
               <div id="row-{{ $comment->id }}" class="col-12 comment-item row position-relative"
                   data-id="{{ $comment->id }}">
                   <div class="col-lg-3">
                       <img
                           src="{{ asset(isset($comment->user['avatar']) ? $comment->user['avatar'] : 'resources/front/images/user.png') }}" />
                   </div>
                   <div class="col-lg-9 row">
                       @manager
                       <button class="btn btn-transparent remove-comment remove" data-id="{{ $comment->id }}"
                           data-type="comment" data-from="front"><i class="fa fa-trash text-danger"></i></button>
                       @endmanager
                       <div class="col-12 text-primary">
                           {{ $comment->comment }}
                       </div>
                       <div class="col-12 header row text-secondary">
                           <div class="col-4">
                               <i class="fa fa-user"></i>
                               {{ $comment->username ?? 'مجهول' }}
                           </div>
                           <div class="col-4">
                               <i class="fa fa-envelope"></i>
                               {{ $comment->email ?? ' ' }}
                           </div>
                           <div class="col-4">
                               <i class="fa fa-clock"></i>
                               {{ $comment->created_at->diffForHumans() }}
                           </div>
                       </div>
                   </div>
               </div>
           @endforeach
       </div>
   </div>
   <script>
       var add_comment = "{{ route('comment.store') }}";
       var delete_comment = "{{ route('comment.delete') }}";
       var manager = {{ $manager }};
   </script>


