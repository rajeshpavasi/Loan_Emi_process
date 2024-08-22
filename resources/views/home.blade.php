@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('LoanDetails') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"> S.No</th>
                                <th scope="col"> clientid</th>
                                <th scope="col"> num_of_payment </th>
                                <th scope="col"> first_payment_date </th>
                                <th scope="col"> last_payment_date</th>
                                <th scope="col"> loan_amount </th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($LoanDetail as $k=> $details)
                            <tr>
                                <td scope="col"> {{ $k+1 }} </td>
                                <td> {{ $details->clientid}} </td>
                                <td> {{ $details->num_of_payment}} </td>
                                <td> {{ $details->first_payment_date}} </td>
                                <td> {{ $details->last_payment_date}} </td>
                                <td> {{ $details->loan_amount}} </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                  
                </div>

            </div>
        </div>
    </div>
</div>
<div style="padding-left: 44%;padding-top: 3%">
<a <button type="button"  href="{{ route('emi')}}"   class="btn btn-primary">Process Data</button> </a>
</div>

@endsection
