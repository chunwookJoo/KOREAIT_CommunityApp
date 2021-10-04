{{-- 내 게시글 --}}
@extends('Layouts.MenuTitle-Back')
@section('menu-title-back')
<link href="{{ asset('/css/Preferences/MessageList.css') }}" rel="stylesheet" />

	<ul id="message_list">
		@foreach ($response as $index => $item)
		<div class="message">
			<li>
				<a href="{{ route('MessageDetail', ['id' => $item['message_id']]) }}">
					<h5>
						{{ $item["title"] }}
					</h5>
					<span>{{ $item["sender"] }}</span>
					<span>{{ $item["time_sent"]}}</span>
				</a>
			</li>
		</div>
		@endforeach
	</ul>
	<script src="{{ asset('js/Preferences/MessageList.js') }}"></script>
@endsection
