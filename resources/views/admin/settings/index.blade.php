@extends('layouts.admin')

@section('title')
    Settings
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (isset($messages))
                @include('admin._partials.messages')
            @endif

            @if (isset($errors))
                @include('admin._partials.errors')
            @endif

            <form action="{{ route('admin.settings.update') }}" method="post">
                {{ csrf_field() }}

                <div class="form-group row">
                    <label for="monthly-cost" class="col-sm-2 col-form-label">Monthly Cost</label>

                    <div class="col-sm-3 input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input id="monthly-cost" class="form-control" type="text" name="monthly_cost"
                               value="{{{ $settings->monthly_cost }}}">
                    </div>
                </div>

                <div class="row">
                <div class="col-sm-10 ml-auto">
                    <input class="btn btn-primary" type="submit" value="Save Settings">
                    <input class="btn btn-warning" type="reset" value="Reset">
                </div>
                </div>
            </form>
        </div>
    </div>
@stop
