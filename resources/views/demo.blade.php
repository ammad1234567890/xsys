@extends('layouts.app')

@section('content')
	<example-component></example-component>
	<?php
		$a="Hello";
	?>
	{{$a}}
@endsection