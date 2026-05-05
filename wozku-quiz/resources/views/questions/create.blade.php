<!DOCTYPE html>
<html>
<head>
<title>Add Question</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>Add Question - {{ $quiz->title }}</h2>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="/quizzes/{{ $quiz->id }}/questions/store" enctype="multipart/form-data">
@csrf

<div class="mb-3">
<label>Question Type</label>
<select name="type" id="type" class="form-control">
<option value="binary">Binary</option>
<option value="single">Single Choice</option>
<option value="multiple">Multiple Choice</option>
<option value="number">Number Input</option>
<option value="text">Text Input</option>
</select>
</div>

<div class="mb-3">
<label>Question</label>
<textarea name="question_text" class="form-control"></textarea>
</div>

<div class="mb-3">
<label>Upload Question Image</label>
<input type="file" name="image" class="form-control">
</div>

<div class="mb-3">
<label>Video URL</label>
<input type="text" name="video_url" class="form-control">
</div>

<div class="mb-3">
<label>Marks</label>
<input type="number" name="marks" value="1" class="form-control">
</div>

<div class="mb-3" id="answerBox">
<label>Correct Answer</label>
<input type="text" name="correct_answer" class="form-control">
</div>

<div id="optionsBox">

<h5>Options</h5>

@for($i = 0; $i < 4; $i++)

<div class="border p-3 mb-3">

<input type="text" name="options[]" class="form-control mb-2" placeholder="Option {{ $i + 1 }} Text">

<input type="file" name="option_images[]" class="form-control mb-2">

<label>
<input type="checkbox" name="correct_options[]" value="{{ $i }}">
 Correct
</label>

</div>

@endfor

</div>

<button class="btn btn-primary">Save Question</button>

</form>

<hr class="mt-5">

<h3>Added Questions</h3>

@foreach($quiz->questions as $question)

<div class="card mb-3 p-3">

<strong>{!! $question->question_text !!}</strong>

<br>
Type: {{ $question->type }} |
Marks: {{ $question->marks }}

@if($question->correct_answer)
<br>
Correct Answer: {{ $question->correct_answer }}
@endif

@if($question->image)
<br><br>
<img src="{{ asset('storage/' . $question->image) }}" width="200">
@endif

@if($question->video_url)
<br><br>
<a href="{{ $question->video_url }}" target="_blank">Watch Video</a>
@endif

@if($question->options->count())
<ul class="mt-3">
@foreach($question->options as $option)

<li class="mb-3">

@if($option->option_text)
{{ $option->option_text }}
@endif

@if($option->image)
<br>
<img src="{{ asset('storage/' . $option->image) }}" width="120">
@endif

@if($option->is_correct)
✅
@endif

</li>

@endforeach
</ul>
@endif

<form method="POST" action="/questions/{{ $question->id }}" class="mt-2">
@csrf
@method('DELETE')
<button class="btn btn-sm btn-danger">Delete</button>
</form>

</div>

@endforeach

</div>

<script>
function toggleFields() {
    let type = document.getElementById('type').value;
    let optionsBox = document.getElementById('optionsBox');
    let answerBox = document.getElementById('answerBox');

    if (type === 'single' || type === 'multiple') {
        optionsBox.style.display = 'block';
        answerBox.style.display = 'none';
    } else {
        optionsBox.style.display = 'none';
        answerBox.style.display = 'block';
    }
}

document.getElementById('type').addEventListener('change', toggleFields);
toggleFields();
</script>

</body>
</html>