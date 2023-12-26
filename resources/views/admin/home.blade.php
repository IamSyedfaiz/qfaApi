@extends('layouts.app')

@section('content')
    <style>
        .calendar-container {
            padding: 20px;
            max-width: 100%;
            margin: 0 auto;
        }

        .calendar-body {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .calendar-day {
            border: 1px solid #ccc;
            text-align: center;
            padding: 10px;
            height: 130px;
            /* Adjust the height */
            width: 130px;
            /* Adjust the width */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .current-date {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }
    </style>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('inc.menu')
            <!-- / Menu -->
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('inc.nav')

                <!-- / Navbar -->
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col col-12 col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class=" d-block mb-2 text-center">Today's Lead</h5>
                                        <h1 class=" mb-2 text-center">{{ $leads->count() }}</h1>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col col-12 col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class=" d-block mb-2 text-center">Appointments</h5>
                                        <h1 class=" mb-2 text-center">0</h1>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col col-12 col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class=" d-block mb-2 text-center">Follow Up</h5>
                                        <h1 class=" mb-2 text-center">{{ $followUps->count() }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="calendar">
                                            <div class="d-flex justify-content-between m-4">
                                                <div>
                                                    <a
                                                        href="{{ route('previousmonth.dashboard', $current_date['formatted']) }}">
                                                        <button class="btn btn-primary">previous month</button> </a>
                                                </div>
                                                <div>
                                                    <a
                                                        href="{{ route('nextmonth.dashboard', $current_date['formatted']) }}">
                                                        <button class="btn btn-primary">next month</button> </a>

                                                </div>
                                            </div>
                                            <h3 class="text-center">{{ $currentmonth . ' ' . $current_year }}</h3>
                                            <ul class="month oct">
                                                @for ($i = 1; $i < $daysinmonth + 1; $i++)
                                                    @if ($current_day == $i && $showpinkbox == true)
                                                        <li class="date-{{ $i }} date active">
                                                            <h5>{{ $i }}</h5>
                                                            <ul class="remind">
                                                                @foreach ($followUps as $item)
                                                                    @php
                                                                        $day = (int) date('d', strtotime($item->date_time));
                                                                        $time = date('H:i', strtotime($item->date_time));

                                                                        $lead = \App\Models\Lead::find($item->lead_id);
                                                                        $futuredate = date('Y-m-d', strtotime($item->followupdate . ' +2 day'));
                                                                        $comparedate = date('Y-m-d', strtotime($current_date['formatted']));
                                                                        $compareyear = \Carbon\Carbon::now()->year;
                                                                        // dd($item->date_time);
                                                                    @endphp
                                                                    @if ($i == $day && $compareyear == $current_year)
                                                                        @if ($futuredate >= $comparedate)
                                                                            <a
                                                                                href="{{ route('admin.lead.view', $lead->id) }}">
                                                                                <li>
                                                                                    {{ $lead->name }} -{{ $time }}
                                                                                </li>

                                                                            </a>
                                                                        @else
                                                                            <li>
                                                                                {{ $lead->name }} -{{ $time }}
                                                                            </li>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @else
                                                        <li class="date-{{ $i }} date">
                                                            <h5>{{ $i }}</h5>
                                                            <ul class="remind">
                                                                @foreach ($followUps as $item)
                                                                    @php
                                                                        $day = (int) date('d', strtotime($item->date_time));
                                                                        $time = date('H:i', strtotime($item->date_time));

                                                                        $lead = \App\Models\Lead::find($item->lead_id);
                                                                        $futuredate = date('Y-m-d', strtotime($item->followupdate . ' +2 day'));
                                                                        $comparedate = date('Y-m-d', strtotime($current_date['formatted']));
                                                                        $compareyear = \Carbon\Carbon::now()->year;
                                                                        // dd($day);
                                                                    @endphp
                                                                    @if ($i == $day && $compareyear == $current_year)
                                                                        @if ($futuredate >= $comparedate)
                                                                            <a
                                                                                href="{{ route('admin.lead.view', $lead->id) }}">
                                                                                <li>
                                                                                    {{ $lead->name }}
                                                                                    -{{ $time }}
                                                                                </li>
                                                                            </a>
                                                                        @else
                                                                            <li>
                                                                                {{ $lead->name }} -{{ $time }}
                                                                            </li>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endif
                                                @endfor


                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->
                </div>
            </div>
        </div>
    </div>
@endsection
