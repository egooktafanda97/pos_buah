@extends('layouts.app')

@section('template_title')
    Kasirs
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Kasirs') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('kasirs.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
									<th >User Id</th>
									<th >Toko Id</th>
									<th >Nama</th>
									<th >Alamat</th>
									<th >Telepon</th>
									<th >Deskripsi</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kasirs as $kasir)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $kasir->user_id }}</td>
										<td >{{ $kasir->toko_id }}</td>
										<td >{{ $kasir->nama }}</td>
										<td >{{ $kasir->alamat }}</td>
										<td >{{ $kasir->telepon }}</td>
										<td >{{ $kasir->deskripsi }}</td>

                                            <td>
                                                <form action="{{ route('kasirs.destroy', $kasir->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('kasirs.show', $kasir->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('kasirs.edit', $kasir->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $kasirs->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
