@extends('layouts.admin')

@section('title')
    Donors
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{ $donors->links() }}

            <div class="table-responsive">
                <table class="table table-hover table-bordered sortable">
                    <thead>
                    <tr>
                        <th>Real Name</th>
                        <th>Ingame Name</th>
                        <th>Total Donated</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($donors as $donor)
                        <tr>
                            <td><a href="{{ route('admin.donors.show', $donor) }}">{{{ $donor->name }}}</a></td>
                            <td>{{{ $donor->ingame_name }}}</td>
                            <td>${{ $donor->total }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{ $donors->links() }}
        </div>
    </div>
@stop