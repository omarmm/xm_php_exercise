<div class="row">
    <div class="col-lg-12">

        <div class="alert alert-info">
            Sample table page
        </div>

        <div class="card">
            <div class="card-body p-0">

                <table class="table">

                    <h4><strong>Historical Data for : {{ $companyName }}</strong> : From {{$startDate}} To {{$endDate}} </h4>

                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Open</th>
                            <th>High</th>
                            <th>Low</th>
                            <th>Close</th>
                            <th>volume</th>



                        </tr>
                    </thead>
                    <tbody>
                    @foreach($historicalQuotes as $quote)
                        <tr>
                            <td>{{ $quote['date'] }}</td>
                            <td>{{ $quote['open'] }}</td>
                            <td>{{ $quote['high'] }}</td>
                            <td>{{ $quote['low'] }}</td>
                            <td>{{ $quote['close'] }}</td>
                            <td>{{ $quote['volume'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->


        </div>

    </div>
</div>