<!DOCTYPE html>
<html>
<head>
    <title>All Quizzes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between mb-4">
        <h2>All Quizzes</h2>
        <a href="/quizzes/create" class="btn btn-primary">Create Quiz</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Action</th>
        </tr>

        @foreach($quizzes as $quiz)
        <tr>
            <td>{{ $quiz->id }}</td>
            <td>{{ $quiz->title }}</td>
            <td>{{ $quiz->description }}</td>
            <td>
                <a href="/quizzes/{{ $quiz->id }}/questions/create" class="btn btn-sm btn-success">
                    Add Questions
                </a>
                <a href="/quizzes/{{ $quiz->id }}/attempt" class="btn btn-sm btn-primary">
                    Attempt Quiz
                </a>
            </td>
        </tr>
        @endforeach

    </table>

</div>

</body>
</html>