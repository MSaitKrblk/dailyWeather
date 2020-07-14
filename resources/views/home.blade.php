@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if ($status)
                        <div class="alert alert-success" role="alert">
                            We will mail you the daily weather
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            Send us the city you want to get daily weather forecasts
                        </div>
                    @endif
                    <div class="bd-example">
                        <form method='post' action="/insert">
                        @csrf
                          <div class="form-group">
                            <label for="inputCity">City</label>
                            <input type="text" class="form-control" id="inputCity" name="inputCity"  placeholder="Enter City" required onkeyup="this.value = this.value.toUpperCase();">
                          </div>
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
