@extends('Layouts.MenuTitle-Back')
<link href="{{ asset('css/Haksa/EvalQuestion.css') }}" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<body>
	<section>
		<form>
			@csrf
			@foreach($response as $index => $item)
			<h5>{{$index + 1}}. {{$item['question']}}</h5>
				<div>
					<label><input class="form-check-input" type="radio" name="q{{$index + 1}}" value="1" checked="true"> 매우 그렇다</label>
					<label><input class="form-check-input" type="radio" name="q{{$index + 1}}" value="2"> 그렇다</label>
					<label><input class="form-check-input" type="radio" name="q{{$index + 1}}" value="3"> 그저 그렇다</label>
					<label><input class="form-check-input" type="radio" name="q{{$index + 1}}" value="4"> 그렇지 않다</label>
					<label><input class="form-check-input" type="radio" name="q{{$index + 1}}" value="5"> 전혀 그렇지 않다</label>
				</div>
				@endforeach
			<footer>
				<p>
					<span>건의사항</span>
				</p>
				<textarea class="form-control" id="floatingTextarea2" name="suggestion" placeholder="내용을 입력하세요"></textarea>
				<p>
					<input class="btn" id="submit-btn" type="button" value="전송하기">
				</p>
			</footer>

		</form>

	</section>
    <script>
        var route='{{route('EvalListPost')}}';
		var haksuCode =  '{{$haksuCode}}';
        var questitonSize= {{count($response)}};
    </script>
     <script src="{{ asset('js/Eval/PostEval.js') }}"></script>
</body>
