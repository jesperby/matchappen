@extends('layouts.master')

@section('content')

  <h1>{{ $workplace->name }}</h1>

  <p>{{ $workplace->description }}</p>

  @include('workplace.partials.admin_edit_link')

@endsection