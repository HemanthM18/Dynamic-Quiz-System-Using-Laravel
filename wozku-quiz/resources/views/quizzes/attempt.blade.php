<!DOCTYPE html>
<html>
<head>
<title>Attempt Quiz</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>{{ $quiz->title }}</h2>
<p>{{ $quiz->description }}</p>

<form method="POST" action="/quizzes/{{ $quiz->id }}/submit">
@csrf

@foreach($quiz->questions as $question)

<div class="card p-3 mb-4">

<h5>{{ $question->question_text }}</h5>
@if($question->image)
<img src="{{ asset('storage/' . $question->image) }}" width="200" class="mb-3">
@endif

@if($question->type == 'binary')
<select name="answers[{{ $question->id }}]" class="form-control">
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
@endif

@if($question->type == 'number' || $question->type == 'text')
<input type="text" name="answers[{{ $question->id }}]" class="form-control">
@endif

@if($question->type == 'single')
@foreach($question->options as $option)

<div class="mb-3">

<input type="radio"
name="answers[{{ $question->id }}]"
value="{{ $option->id }}">

@if($option->option_text)
{{ $option->option_text }}
@endif

@if($option->image)
<br>
<img src="{{ asset('storage/' . $option->image) }}" width="120">
@endif

</div>

@endforeach
@endif

@if($question->type == 'multiple')
@foreach($question->options as $option)

<div class="mb-3">

<input type="checkbox"
name="answers[{{ $question->id }}][]"
value="{{ $option->id }}">

@if($option->option_text)
{{ $option->option_text }}
@endif

@if($option->image)
<br>
<img src="{{ asset('storage/' . $option->image) }}" width="120">
@endif

</div>

@endforeach
@endif

</div>

@endforeach

<button class="btn btn-success">Submit Quiz</button>

</form>

</div>

</body>
</html>