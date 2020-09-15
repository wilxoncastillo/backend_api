@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bienvendos</div>

                <div class="card-body">
                    @if (session('notification'))
                        <div class="alert alert-success" role="alert">
                            {{ session('notification') }}
                        </div>
                    @endif
                    Demo de Backend
                </div>
            </div>
        </div>
    </div>
</div>
@endsection