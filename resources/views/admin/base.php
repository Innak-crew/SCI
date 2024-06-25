@extends('layout.admin-app')
@section('adminContent')

    <!-- main-content-wrap -->
    <div class="main-content-wrap ">
        
    <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>{{ $sectionName }}</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.dashboard') }}"><div class="text-tiny">Admin</div></a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                @if ($title != "Index")
                    <li>
                        <a href="#"><div class="text-tiny">{{$title}}</div></a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                @endif
                <li>
                    <div class="text-tiny">{{ $sectionName }}</div>
                </li>
            </ul>
        </div>

    </div>
    <!-- /main-content-wrap -->

@endsection

