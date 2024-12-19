

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h2>Your Calendar Events</h2>
        
        @foreach($events as $event)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $event->getSummary() }}</h5>
                    <p>Start: {{ $event->getStart()->getDateTime() }}</p>
                    <p>End: {{ $event->getEnd()->getDateTime() }}</p>
                </div>
            </div>
        @endforeach

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">My Calendar</div>
                        <div class="card-body">
                            <iframe src="https://calendar.google.com/calendar/embed?src={{ urlencode(auth()->user()->email) }}" 
                                    style="border: 0" 
                                    width="100%" 
                                    height="600" 
                                    frameborder="0" 
                                    scrolling="no">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>