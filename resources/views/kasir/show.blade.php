@extends('layouts.app')

@section('template_title')
    {{ $kasir->name ?? __('Show') . " " . __('Kasir') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Kasir</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('kasirs.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>User Id:</strong>
                                    {{ $kasir->user_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Toko Id:</strong>
                                    {{ $kasir->toko_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Nama:</strong>
                                    {{ $kasir->nama }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Alamat:</strong>
                                    {{ $kasir->alamat }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Telepon:</strong>
                                    {{ $kasir->telepon }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Deskripsi:</strong>
                                    {{ $kasir->deskripsi }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
