<!DOCTYPE html>
<html>
<head>
    <title>Ticket Notification</title>
</head>
<body>
    <h1>{{ $messageContent }}</h1>
    <p>Ticket ID: {{ $ticket->id }}</p>
    <p>Ticket Code: {{ $ticket->code }}</p>
    <p>Title: {{ $ticket->title }}</p>
    <p>Description: {{ $ticket->description }}</p>
    <p>Description: {{ $ticket->category->name }}</p>
    <p>Status: {{ $ticket->status }}</p>
</body>
</html>
