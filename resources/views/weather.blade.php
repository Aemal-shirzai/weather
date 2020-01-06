<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Weather</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/style2.css')}}">
    <link rel="icon" type="image/png" href="{{asset('images/bg1.jpg')}}">
</head>
<body>


	<div id="formDiv">
		<h3>Check Weather Condition</h3>
		<h6>Enter name of a city</h6>
		{!! Form::open(["method"=>"get","action"=>"weatherController@search","id"=>"searchForm"]) !!}
			<div class="input-group form-elements">
				{!! Form::text("search_for",request()->input('search_for'),["class"=>"form-control","placeholder"=>"type city name ...","autofocus"=>"true","id"=>"searchField"]) !!}
				<img src="{{asset('images/load.gif')}}" id="loading">
				{!! Form::submit("Search",["class"=>"btn btn-sm btn-primary","id"=>"submitButton"]) !!}
			</div>
		{!! Form::close() !!}
	</div>

	<div id="data">
		@isset($cityName)
			<h2>{{ $mainCondition }}</h2>
			<div id="details">It is {{ $description }} in {{ $cityName }},{{ $country }} with <span id="degree">{{ $degree }}</span> c&deg;</div>
			<div id="icon"><img id="icon-image" alt="Weather icon" src="http://openweathermap.org/img/wn/{{$icon}}@2x.png"></div>
		@endisset
		@isset($notFound)
			<h2>{{ $notFound }}</h2>
		@endisset
	</div>


<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
<script type="text/javascript" src="{{asset('js/script.js')}}"></script>
<script type="text/javascript">
	var token = '{{ Session::token() }}';
	var weatherUrl = "{{route('search.weather')}}";
</script>
</body>
</html>