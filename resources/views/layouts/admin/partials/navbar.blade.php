<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto mr-3">
        {{-- <x-chat-component></x-chat-component> --}}

        <li class="nav-item" id="countMessage">
            <a class="nav-link" href="{{route('admin.connection.live.chat')}}">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">{{\App\Models\Chat::where('admin_message_log', 'incoming')->where('admin_status', false)->count()}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
              <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>