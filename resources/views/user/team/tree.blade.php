@extends('layouts.user.app')

@section('title', 'Tree View')

@push('css')
    
    <style>
        /*----------------genealogy-scroll----------*/

        .genealogy-scroll::-webkit-scrollbar {
            width: 5px;
            height: 8px;
        }
        .genealogy-scroll::-webkit-scrollbar-track {
            border-radius: 10px;
            background-color: #e4e4e4;
        }
        .genealogy-scroll::-webkit-scrollbar-thumb {
            background: #212121;
            border-radius: 10px;
            transition: 0.5s;
        }
        .genealogy-scroll::-webkit-scrollbar-thumb:hover {
            background: #d5b14c;
            transition: 0.5s;
        }


        /*----------------genealogy-tree----------*/
        .genealogy-body{
            white-space: nowrap;
            overflow-y: hidden;
            padding: 50px;
            min-height: 500px;
            padding-top: 10px;
        }
        .genealogy-tree ul {
            padding-top: 20px; 
            position: relative;
            padding-left: 0px;
            display: flex;
        }
        .genealogy-tree li {
            float: left; text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;
        }
        .genealogy-tree li::before, .genealogy-tree li::after{
            content: '';
            position: absolute; 
            top: 0; 
            right: 50%;
            border-top: 2px solid #ccc;
            width: 50%; 
            height: 18px;
        }
        .genealogy-tree li::after{
            right: auto; left: 50%;
            border-left: 2px solid #ccc;
        }
        .genealogy-tree li:only-child::after, .genealogy-tree li:only-child::before {
            display: none;
        }
        .genealogy-tree li:only-child{ 
            padding-top: 0;
        }
        .genealogy-tree li:first-child::before, .genealogy-tree li:last-child::after{
            border: 0 none;
        }
        .genealogy-tree li:last-child::before{
            border-right: 2px solid #ccc;
            border-radius: 0 5px 0 0;
            -webkit-border-radius: 0 5px 0 0;
            -moz-border-radius: 0 5px 0 0;
        }
        .genealogy-tree li:first-child::after{
            border-radius: 5px 0 0 0;
            -webkit-border-radius: 5px 0 0 0;
            -moz-border-radius: 5px 0 0 0;
        }
        .genealogy-tree ul ul::before{
            content: '';
            position: absolute; top: 0; left: 50%;
            border-left: 2px solid #ccc;
            width: 0; height: 20px;
        }
        .genealogy-tree li a{
            text-decoration: none;
            color: #666;
            font-family: arial, verdana, tahoma;
            font-size: 11px;
            display: inline-block;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
        }

        .genealogy-tree li a:hover+ul li::after, 
        .genealogy-tree li a:hover+ul li::before, 
        .genealogy-tree li a:hover+ul::before, 
        .genealogy-tree li a:hover+ul ul::before{
            border-color:  #fbba00;
        }

        /*--------------memeber-card-design----------*/
        .member-view-box{
            padding:0px 20px;
            text-align: center;
            border-radius: 4px;
            position: relative;
        }
        .member-image{
            width: 60px;
            position: relative;
        }
        .member-image img{
            width: 60px;
            height: 60px;
            border-radius: 6px;
            background-color :#000;
            z-index: 1;
        }
        .member-details h3 {
            font-size: 13px;
            margin-top: 3px;
        }


    </style>
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tree View</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Tree View</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Title</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="body genealogy-body genealogy-scroll">
                <div class="genealogy-tree">
                    <ul>
                        <li>
                            <a href="javascript:void(0);">
                                <div class="member-view-box">
                                    <div class="member-image">
                                        <img src="{{Auth::user()->avatar != 'default.png' ? '/uploads/member/'.Auth::user()->avatar:'https://image.flaticon.com/icons/svg/145/145867.svg'}}" alt="Member">
                                        <div class="member-details">
                                            <strong>{{Auth::user()->referer_id}}</strong>
                                            <h3>{{Auth::user()->username}}</h3>
                                            
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @if (Auth::user()->children->count() > 0)
                            <ul class="active">
                                @foreach (Auth::user()->orderByChildren() as $key => $children_one)
                                <li>
                                    <a href="{{route('team.tree.view.id', $children_one->id)}}">
                                        <div class="member-view-box">
                                            <div class="member-image">
                                                <img src="{{$children_one->avatar != 'default.png' ? '/uploads/member/'.$children_one->avatar:'https://image.flaticon.com/icons/svg/145/145867.svg'}}" alt="Member">
                                                <div class="member-details">
                                                    <strong>
                                                        @if ($children_one->direction == 1)
                                                            Left
                                                        @elseif ($children_one->direction == 2)
                                                            Middle
                                                        @else 
                                                            Right
                                                        @endif
                                                    </strong><br>
                                                    <strong>{{$children_one->referer_id}}</strong>
                                                    <h3>{{$children_one->username}}</h3>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    @if ($children_one->children->count() > 0)
                                    <ul class="active">
                                        
                                        @foreach ($children_one->orderByChildren() as $key => $children_two)
                                        <li id="{{$key + 1}}">
                                            <a href="{{route('team.tree.view.id', $children_two->id)}}">
                                                <div class="member-view-box">
                                                    <div class="member-image">
                                                        <img src="{{$children_two->avatar != 'default.png' ? '/uploads/member/'.$children_two->avatar:'https://image.flaticon.com/icons/svg/145/145867.svg'}}" alt="Member">
                                                        <div class="member-details">
                                                            <strong>
                                                                @if ($children_two->direction == 1)
                                                                    Left
                                                                @elseif ($children_two->direction == 2)
                                                                    Middle
                                                                @else 
                                                                    Right
                                                                @endif
                                                            </strong><br>
                                                            <strong>{{$children_two->referer_id}}</strong>
                                                            <h3>{{$children_two->username}}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                    
                                </li>
                                @endforeach
                            </ul>
                            @endif
                            
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    

</section>
<!-- /.content -->

@endsection
