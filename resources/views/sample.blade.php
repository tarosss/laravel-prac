@extends('layouts.categories.tshirt')

@push('sub-content')
<h4>subコンテンツに書いてみた</h4>
@endpush
@section('content')
<x-sample-component
  data="1"
  data2="10" />
@endsection
@section('top', 'トップのコンテンツ')


@push('sub-content')
<h4>subコンテンツに書いてみた2つめ</h4>
@endpush