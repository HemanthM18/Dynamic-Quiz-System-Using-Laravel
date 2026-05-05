<!DOCTYPE html>
<html>
<head>
<title>Quiz Result</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<div class="card p-5 text-center">

<h2>{{ $attempt->quiz->title }}</h2>

<h3 class="mt-4">Quiz Submitted Successfully</h3>

<h1 class="text-success mt-3">
{{ $attempt->score }} / {{ $totalMarks }}
</h1>

<a href="/quizzes" class="btn btn-primary mt-4">
Back to Quiz List
</a>

</div>

</div>

</body>
</html>