@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Liste des Formulaires</div>

                <div class="panel-body">
                    {{ $note}}
                </div>


                @foreach ($formulaires as $formulaire)
                  {{ $formulaire->name }}
                    @foreach ($formulaire->user as $user)
                        {{$user->name}} - <br>
                    @endforeach
<br><br>
                @endforeach




                <div class="panel panel-primary">
          			<div class="panel-heading">
          				<h3 class="panel-title">Liste des utilisateurs</h3>
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
          					@foreach ($formulaires as $formulaire)
          						<tr>
          							<td>{!! $formulaire->id !!}</td>
          							<td class="text-primary"><strong>{!! $formulaire->name !!}</strong></td>
          							<td>{!! link_to_route('formulaire.show', 'Voir', [$formulaire->id], ['class' => 'btn btn-success btn-block']) !!}</td>
          							<td>{!! link_to_route('formulaire.edit', 'Modifier', [$formulaire->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
          							<td>
          								{!! Form::open(['method' => 'DELETE', 'route' => ['formulaire.destroy', $formulaire->id]]) !!}
          									{!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Vraiment supprimer cet utilisateur ?\')']) !!}
          								{!! Form::close() !!}
          							</td>
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
