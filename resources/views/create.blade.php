@extends('layout')

@section('title', 'Save a New Conversion')


@section('page_head', 'Create a Conversion')

@section('content')   
        <form method="post" action="{{ route('conversion.store') }}" class="form-inline">
        {{csrf_field()}}
        <div class="row">
        <div class="col-md-4 form-group">
        <label for="currency1" class="h4 mb-2">Currency 1</label>
        <select name="currency1" class="form-control">
        @foreach($symbols as $symbol) 
            <option value="{{ $symbol }}">{{ $symbol }}</option>
        @endforeach
        </select>
        </div>
        <div class="col-md-4 form-group">
        <label for="currency2" class="h4 mb-2">Currency 2</label>
        <select name="currency2" class="form-control">
        @foreach($symbols as $symbol) 
            <option value="{{ $symbol }}">{{ $symbol }}</option>
        @endforeach
        </select>
        </div>
        <div class="col-md-4">
        <input type="submit" class="btn btn-primary mt-4" value="Submit">
        </div>
        </div>
        </form>
@endsection