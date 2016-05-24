@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">services</div>

                <div class="panel-body">
                    {{ $note}}
                  : {{  Auth::user()->name }} #{{  Auth::user()->id }}
                </div>


                @foreach ($services as $service)
                  {{ $service->name }}
                  @foreach($service->user as $user)
                    {{ $user-> name }}

                  @endforeach


<br><br>
                @endforeach




                <div class="panel panel-primary">
          			<div class="panel-heading">
          				<h3 class="panel-title">{{ $note}}</h3>
          			</div>
          			<table class="table">
          				<thead>
          					<tr>
          						<th>#</th>
          						<th>Nom</th>
          						<th></th>
          						<th></th>
          						<th></th>
          					</tr>
          				</thead>
          				<tbody>
          					@foreach ($services as $service)
          						<tr>
          							<td>{!! $service->id !!}</td>
          							<td class="text-primary"><strong>{!! $service->name !!}</strong></td>

          							<td>{!! link_to_route('service.show', 'Voir', [$service->id], ['class' => 'btn btn-success btn-block']) !!}</td>
@if (Auth::user()->admin)
          							<td>{!! link_to_route('service.edit', 'Modifier', [$service->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
          							<td>
          								{!! Form::open(['method' => 'DELETE', 'route' => ['service.destroy', $service->id]]) !!}
          									{!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Vraiment supprimer ce service ?\')']) !!}
          								{!! Form::close() !!}
          							</td>
@endif

          						</tr>
          					@endforeach
          	  			</tbody>
          			</table>
          		</div>






            </div>
        </div>
    </div>
</div>
@endsection
