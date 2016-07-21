@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Vue Generique</div>

                <div class="panel-body">

                  {{$note}}
                </div>



                <div class="panel panel-primary">
          			<div class="panel-heading">
          				<h3 class="panel-title"></h3>
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
                    @foreach ($datas as $data)
                        {{ $data}}


          					@endforeach

          	  			</tbody>
          			</table>
          		</div>






            </div>
        </div>
    </div>
</div>
@endsection
