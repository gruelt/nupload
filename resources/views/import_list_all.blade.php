@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Formulaires</div>

                <div class="panel-body">
                    {{ $note}}
                  : {{  Auth::user()->name }} #{{  Auth::user()->id }}
                </div>







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
                      <th></th>
          						<th></th>
          					</tr>
          				</thead>
          				<tbody>
          					@foreach ($list as $folder)
          						<tr>
          							<td>{!! $folder !!}</td>
          							<td class="text-primary"><strong>{!! $folder !!}</strong></td>

          							<td>{!! link_to_route('import.show', 'Voir', [$folder], ['class' => 'btn btn-info btn-block']) !!}</td>
          							<td>{!! link_to_route('import.go', 'Importer', [$folder], ['class' => 'btn btn-success btn-block']) !!}</td>






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
