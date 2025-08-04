@extends('layouts.guest')

@section('meta_title', 'Blogs - GoldenX')
@section('meta_description', 'Explore the latest blogs and articles on GoldenX.')
@section('canonical',"")

@section('script_css')
<meta itemprop="image" content="">
<meta property="og:image" content="" />
<meta name="twitter:image" content="" />
@append

@section('content')
@livewire('blog-detail-component',['slug' => $slug])
@endsection