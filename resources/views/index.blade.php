
@extends('layout')

@section('title', 'Currency Converter')

@section('page_head', 'Conversions')

@section('content')
    @if($list->count()>0)
        <table class="table table-striped">
        <thead>
        <tr>
            <th>Currency 1</th>
            <th>Currency 2</th>
            <th>Rate</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $record) 
            <tr>
            <td>{{ $record -> currency1 }}</td>
            <td>{{ $record -> currency2 }}</td> 
            <td>{{ $record -> rate }}</td>
            <td class="float-right">
            <form action="{{ URL::route('conversion.destroy', $record->id) }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button class="btn btn-primary">Delete</button>
            </form>
            </td>
            </tr>
        @endforeach
        </tbody>
        </table>
    @else 
        There are no records yet
    @endif
@endsection