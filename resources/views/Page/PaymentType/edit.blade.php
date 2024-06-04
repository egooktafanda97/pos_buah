@extends('Template.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!-- Breadcrumb -->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Edit Payment Type</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Payment Type</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{ route('paymenttype.index') }}" class="btn btn-secondary"><i
                                class='bx bx-arrow-back'></i> Kembali</a>
                    </div>
                </div>
            </div>
            <!-- End breadcrumb -->

            <h6 class="mb-0 text-uppercase">Edit Payment Type</h6>
            <hr />

            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div><i class="bx bxs-wallet me-1 font-22 text-primary"></i></div>
                        <h5 class="mb-0 text-primary">Payment Type Details</h5>
                    </div>
                    <hr>

                    <form action="{{ route('paymenttype.update', $paymentType->id) }}" method="POST"
                        enctype="multipart/form-data" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter payment type name" value="{{ old('name', $paymentType->name) }}"
                                required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Enter payment type description"
                                value="{{ old('description', $paymentType->description) }}">
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="icon" class="form-label">Icon</label>
                            <input type="file" class="form-control" id="icon" name="icon">
                            @if ($paymentType->icon)
                                <img src="{{ asset('image/icons/' . $paymentType->icon) }}" alt="Icon" width="50"
                                    class="mt-2">
                            @endif
                            @error('icon')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col">
                            <button type="submit" class="btn btn-outline-success"><i class='bx bx-save me-0'></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
