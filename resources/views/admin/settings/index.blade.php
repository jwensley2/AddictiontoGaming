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

            <form class="form-horizontal" action="{{ route('admin.settings.update') }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="form-group">
                    <label class="col-sm-2 control-label">Monthly Cost</label>

                    <div class="col-sm-3 input-group">
                        <span class="input-group-addon">$</span>
                        <input class="form-control" type="text" name="monthly_cost" value="{{{ $settings->monthly_cost }}}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input class="btn btn-primary" type="submit" value="Save Settings">
                        <input class="btn btn-warning" type="reset" value="Reset">
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop