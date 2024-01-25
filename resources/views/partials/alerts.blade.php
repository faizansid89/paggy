@if($errors->any())
    <div class="alert alert-pro alert-danger">
        <div class="alert-text">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if(Session::has('alert-success'))
    <div class="alert alert-pro alert-success">
        {{ Session::get('alert-success') }}
    </div>
@endif

@if(Session::has('alert-danger'))
    <div class="alert alert-pro alert-danger">
        {{ Session::get('alert-danger') }}
    </div>
@endif

{{--@if($errors->any())--}}
{{--    <div class="alert alert-pro alert-danger">--}}
{{--        <div class="alert-text">--}}
{{--            {{ implode('', $errors->all(':message')) }}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endif--}}
