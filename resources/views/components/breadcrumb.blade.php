<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">

                    @isset($breadcrumbs)
                    @foreach($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item">
                            @if(isset($breadcrumb['route']))
                                <a href="{{ route($breadcrumb['route']) }}">{{ $breadcrumb['label'] }}</a>
                            @else
                                {{ $breadcrumb['label'] }}
                            @endif
                        </li>
                    @endforeach
                    @endisset
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
