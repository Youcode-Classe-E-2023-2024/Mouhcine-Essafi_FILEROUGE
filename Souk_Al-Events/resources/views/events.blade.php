@extends('layout.main')

@section('content')

<!-- Search Start -->
<div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
    <div class="container">
        <form action="{{url('events')}}" method="get">
            <div class="row g-2 align-items-center">
                <div class="col-md-3">
                    <input type="text" name="search" id="search" class="form-control border-0 py-4" placeholder="Search By Keyword">
                </div>
                <div class="col-md-2">
                    <select class="form-select border-0 py-3" name="organizer" onchange="this.form.submit()">
                        <option value="">Event Organizers</option>
                        @foreach ($allOrganizers as $org)
                        <option value="{{$org->id}}">{{$org->org_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select border-0 py-3" name="location" onchange="this.form.submit()">
                        <option value="">Location</option>
                        @foreach ($cities as $city)
                        <option value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select border-0 py-3" name="eventType" onchange="this.form.submit()">
                        <option value="">Event Types</option>
                        @foreach ($eventTypes as $eventType)
                        <option value="{{$eventType->event_type_name}}" @if ($selectedEventType==$eventType->event_type_name) selected @endif>{{$eventType->event_type_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-dark border-0 w-100 py-3">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Search End -->


<!-- Property List Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-0 gx-5 align-items-end">
            <div class="col-lg-6">
                <div class="text-start mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">
                    <div class="d-flex align-items-center">

                        @if ($search != "") <h2 class="mb-3">{{"("}} Search: {{$search." )" }}</h2> <span class="ms-2 text-primary"> Total Results ( {{$eventCount}} )</span>

                        @elseif($organizer != "") <h2 class="mb-3">{{"("}} Organizer: {{Custom::orgName($organizer)." )"}} </h2> <span class="ms-2 text-primary"> Total Results ( {{$eventCount}} )</span>

                        @elseif($location != "") <h2 class="mb-3">{{"("}} Location: {{Custom::cityName($location)." )"}} </h2> <span class="ms-2 text-primary"> Total Results ( {{$eventCount}} )</span>

                        @else <h2> Upcomming Events </h2> @endif
                    </div>
                    <p>Eirmod sed ipsum dolor sit rebum labore magna erat. Tempor ut dolore lorem kasd vero ipsum sit eirmod sit diam justo sed rebum.</p>
                </div>
            </div>
            <div class="col-lg-6 text-start text-lg-end wow slideInRight" data-wow-delay="0.1s">
                <form action="{{route('home')}}" method="get">
                    <ul class="nav nav-pills d-inline-flex justify-content-end mb-5">
                        <li class="nav-item me-2">
                            <button name="featured" class="btn btn-outline-primary active" data-bs-toggle="pill" href="#tab-1">Featured</button>
                        </li>
                        <li class="nav-item me-2">
                            <button name="freeEvents" class="btn btn-outline-primary" data-bs-toggle="pill" href="#tab-2">Free</button>
                        </li>
                        <li class="nav-item me-0">
                            <button name="paidEvents" class="btn btn-outline-primary" data-bs-toggle="pill" href="#tab-3">Paid</button>
                        </li>

                    </ul>

                </form>
            </div>
        </div>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane fade show p-0 active">
                <div class="row g-4">


                    @foreach ($events as $event)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="property-item rounded overflow-hidden">
                            <div class="position-relative property-item-display overflow-hidden">
                                <a href="{{url('events')}}/{{$event->event_slug}}"><img class="img-responsive" src="{{url(Custom::eventImagePath($event->event_id))}}" alt="" height="237px" width="100%"></a>
                                @if ($event->event_subscription == 'F')
                                <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">Free</div>
                                @elseif($event->event_subscription == 'P')
                                <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">Paid</div>
                                @endif
                                <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">{{Custom::orgName($event->event_author_id)}}</div>
                            </div>
                            <div class="p-4 pb-0">
                                @if ($event->event_subscription == 'F')
                                <h5 class="text-primary mb-3">0 DH</h5>
                                @elseif($event->event_subscription == 'P')
                                <h5 class="text-primary mb-3">{{$event->event_ticket_price}} DH</h5>
                                @endif
                                <a class="d-block h5 mb-2" href="{{url('events')}}/{{$event->event_slug}}">{{$event->event_name}}</a>
                                <p><i class="fa fa-map-marker-alt text-primary me-2"></i>{{$event->event_address}}, {{$city->name}}</p>
                            </div>
                            <div class="d-flex border-top">
                                <small class="flex-fill text-center border-end py-2"><i class="fa fa-users text-primary me-2"></i>{{Custom::availableSeats($event->event_id)}} Left</small>
                                <small class="flex-fill text-center border-end py-2"><i class="fa fas fa-calendar-alt text-primary me-2"></i>{{$event->event_start_date}}</small>
                                <small class="flex-fill text-center py-2"><i class="fa far fa-clock text-primary me-2"></i>{{$event->event_start_time}}</small>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </div>
                <!-- Pagination links -->

                <div class="row">
                    {{ $events->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>



        @endsection