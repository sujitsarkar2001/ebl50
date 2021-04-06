<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        
        @foreach ($pages as $page)
            @if (Auth::user()->is_admin == true)
                <a href="{{route('admin.view.page', $page->slug)}}" >{{$page->name}}</a>
            @else
                <a href="{{route('view.page', $page->slug)}}" >{{$page->name}}</a>
            @endif
            
        @endforeach
        
    </div>
    
    <strong>{{setting('copy_right_text')}}</strong>
</footer>