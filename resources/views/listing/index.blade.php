@extends('layouts')

@include('partials._hero')
@include('partials._search')

@if(session()->has('message'))
<div x-data="{show: true}" x-init="setTimeout(() => show = false, 2000)" x-show="show"
  class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-laravel text-white px-48 py-3">
  <p>
    {{session('message')}}
  </p>
</div>
@endif

@section('content')
    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">
       
        @if (count($listings) == 0)
            <h2>No Recipe found</h2>
        @endif

        @foreach ($listings as $listing)
            <div class="bg-gray-50 border border-gray-200 rounded p-6">
                <div class="flex">
                    <img class="hidden w-48 mr-6 md:block" src="{{$listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-image.jpg')}}" alt="" />
                    <div>
                        <h3 class="text-2xl">                            
                            <a href="/listing/{{ $listing->id }}">{{ $listing->title }}</a>
                        </h3>
                        <div class="text-xl font-bold mb-4">{{ $listing->company }}</div>
                        @php
                            $tags = explode(',', $listing->tags);
                        @endphp
                        <ul class="flex">
                            @foreach ($tags as $tag)
                                <li class="bg-black text-white rounded-xl px-3 py-1 mr-2">
                                    <a href="?/tag={{ $tag }}">{{ $tag }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="text-lg mt-4">
                            <i class="fa-solid fa-location-dot"></i>{{ $listing->location }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    
    <div class="mt-6 p-4">
        {{$listings->links()}}
      </div>
@endsection
