<!DOCTYPE html>
<html>

<head>
    <title>Ticket Notification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.css"
        integrity="sha512-VcyUgkobcyhqQl74HS1TcTMnLEfdfX6BbjhH8ZBjFU9YTwHwtoRtWSGzhpDVEJqtMlvLM2z3JIixUOu63PNCYQ=="
        crossorigin="anonymous" />
</head>

<body style="background-color: #edf2f7">

    <div class="d-flex flex-column align-items-center px-0 px-sm-4 py-4">
        <h4 class="text-dark text-center mb-4">Ticket Board</h4>
        <div class="bg-white p-2 py-4 px-sm-4 rounded-0 rounded-sm-2 shadow-sm text-muted"
            style="width: 100%; max-width: 800px">
            <h5 class="text-dark mb-4">Un ticket è stato chiuso</h5>
            <p style="font-size: 0.9rem;" class="mb-3">Qui sotto puoi trovare tutte le informazioni relative al ticket
            </p>
            <ul class="list-group">
                <li class="list-group-item d-flex flex-column flex-sm-row gap-1 gap-sm-2 gap-md-3">
                    <span style="font-weight: 600;" class="w-25 text-sm-end d-inline-block">Codice: </span>
                    <span class="w-75">
                        {{ $ticket->code }}
                    </span>
                </li>
                <li class="list-group-item d-flex flex-column flex-sm-row gap-1 gap-sm-2 gap-md-3">
                    <span style="font-weight: 600;" class="w-25 text-sm-end d-inline-block">Titolo: </span>
                    <span class="w-75">
                        {{ $ticket->title }}
                    </span>
                </li>
                <li class="list-group-item d-flex flex-column flex-sm-row gap-1 gap-sm-2 gap-md-3">
                    <span style="font-weight: 600;" class="w-25 text-sm-end d-block">Descrizione: </span>
                    <span class="w-75">
                        {{ $ticket->description }}
                    </span>
                </li>
                <li class="list-group-item d-flex flex-column flex-sm-row gap-1 gap-sm-2 gap-md-3">
                    <span style="font-weight: 600;" class="w-25 text-sm-end d-inline-block">Categoria: </span>
                    <span class="w-75">
                        {{ $ticket->category->name }}
                    </span>
                </li>
                <li class="list-group-item d-flex flex-column flex-sm-row gap-1 gap-sm-2 gap-md-3">
                    <span style="font-weight: 600;" class="w-25 text-sm-end d-inline-block">Stato: </span>
                    <span class="w-75">
                        {{ $ticket->status }}
                    </span>
                </li>
            </ul>
        </div>
    </div>

</body>

</html>
