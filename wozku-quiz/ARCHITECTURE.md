# Architecture Decisions

## Core Entities

### Quiz
Stores quiz title and description.

### Question
Linked to quiz. Supports dynamic types using `type` column.

### Option
Stores choices for single/multiple choice questions.

### Attempt
Stores each quiz submission attempt.

### Answer
Stores user submitted answers.

---

## Extensibility

Question types are stored as data (`type`) rather than hardcoded tables.

Future question types can be added by:

- Adding new type value
- Updating frontend rendering
- Updating evaluation logic

Examples:

- File Upload
- Audio Answer
- Match the Following

---

## Relationships

- Quiz hasMany Questions
- Question hasMany Options
- Quiz hasMany Attempts
- Attempt hasMany Answers

---

## Evaluation Logic

Each question is evaluated based on type:

- Binary / Number / Text → compare answer
- Single Choice → compare selected option
- Multiple Choice → compare selected arrays

---

## Why This Design

- Clean relational structure
- Easy maintenance
- Supports scaling
- Easy to extend

## Entities:
- Quiz
- Question
- Option
- Attempt
- Answer

## Design Choice:
- Flexible question types stored using 'type'
- Options stored separately → supports images & extensibility