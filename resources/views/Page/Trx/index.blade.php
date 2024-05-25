@extends('Template.layout')
@push('style')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        referrerpolicy="no-referrer" rel="stylesheet" />
    <style>
        .loading-spinner {
            border: 2px solid #f3f3f3;
            /* Light grey */
            border-top: 2px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <script>
        window.Alpine = Alpine;
        Alpine.start();
    </script>
@endpush
@section('content')
    <div class="page-wrapper" x-data="{
        collection: {},
        prodOrder: [],
        prodSerach: [],
        searchQuery: '',
        searchProdukMethod: 'brcode',
    
    }">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3"></div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li aria-current="page" class="breadcrumb-item active">Data Table</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="w-full p-2 mb-3">
                                <div class="form-group">
                                    <label class="form-label font-semibold" for="exampleFormControlInput1">Produk</label>
                                    <input class="form-control" id="scann" placeholder="Cari Produk" type="text"
                                        x-model="searchQuery"
                                        x-on:keyup="fetch(`/api/produk/search/${searchQuery}`)
                                             .then(response => response.json())
                                             .then(data => prodSerach = data)
                                             .catch(error => prodSerach = [])">
                                    {{-- tampilkan pilihan dengan radio button brcode atau search --}}
                                    <div class="mt-1">
                                        <label class="inline-flex items-center">
                                            <input checked class="form-radio" name="searchType" type="radio"
                                                value="brcode" x-model="searchProdukMethod">
                                            <span class="ml-2">Barcode</span>
                                        </label>
                                        <label class="inline-flex items-center ml-6">
                                            <input class="form-radio" name="searchType" type="radio" value="search"
                                                x-model="searchProdukMethod">
                                            <span class="ml-2">Search</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="relative w-full mt-2" x-show="searchProdukMethod == 'search'">
                                    <div class="absolute inset-0">
                                        <template :key="prod.id" x-for="prod in prodSerach">
                                            <div class="bg-gray-50 shadow-sm p-2 flex items-center hover:bg-gray-100 active:bg-gray-300"style="cursor:pointer"
                                                x-on:click="addToProdOrder(prod)">
                                                <div class="w-10">
                                                    <img alt="Icon"
                                                        src="https://icon-library.com/images/point-of-sales-icon/point-of-sales-icon-9.jpg">
                                                </div>

                                                <div class="flex-1 pl-2 mr-16">
                                                    <div class="font-semibold text-sm" x-text="prod.nama_produk"></div>
                                                    <template :key="hargaItem.id" x-for="hargaItem in prod.harga">
                                                        <p>
                                                            Harga: <span x-text="hargaItem.harga"></span>
                                                            / (<span x-text="hargaItem.jenis_satuan.nama"></span>)
                                                        </p>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <h3 class=" m-1 font-semibold text-lg">Produk Order</h3>
                            {{-- <hr class="m-1"> --}}
                            <div class=" p-2 rounded-md shadow-md m-1">

                                <div class="flex items-center p-4 bg-white rounded-lg">
                                    <img alt="Produk Image" class="w-10 h-10 rounded-lg"
                                        src="https://via.placeholder.com/100">
                                    <div class="flex-1 flex flex-col ml-4">
                                        <span class="font-semibold text-lg text-gray-800">Nomad Tumbler</span>
                                        <div class="flex items-center">
                                            <span class="text-sm text-gray-500 mr-5">Rp. 10,000</span>
                                            <select
                                                class="border w-20 border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center border border-gray-300 rounded-md mr-10">
                                            <button class="px-2 py-1" onclick="decrementQty(this)">-</button>
                                            <input class="w-12 text-center border-l border-r border-gray-300" readonly
                                                type="text" value="1">
                                            <button class="px-2 py-1" onclick="incrementQty(this)">+</button>
                                        </div>
                                        <div class="text-lg font-semibold text-gray-800">$35.00</div>
                                        <button class="text-red-500 hover:underline">
                                            <i class="fa fa-remove text-xl"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-2 rounded-md shadow-md m-1">
                                <div class="max-w-lg mx-auto mb-5">
                                    <div class="form-group mb-3 relative">
                                        <label class="form-label font-semibold" for="exampleFormControlInput1">Nomor
                                            Pelanggan</label>
                                        <div class="flex items-center">
                                            <input class="form-control border border-gray-300 rounded-md py-2 px-3 flex-1"
                                                id="scann" placeholder="Cari Produk" type="text">
                                            <div class="hidden ml-2" id="loadings">
                                                <i class="fas fa-spinner fa-spin text-gray-500"></i>
                                            </div>
                                        </div>
                                        <div class="hidden text-red-500 text-sm mt-2" id="error-message">Pelanggan tidak
                                            ditemukan.</div>
                                    </div>
                                </div>
                                <hr class="mb-2">
                                <div class="flex justify-between items-center mb-3">
                                    <div class="flex items-center">
                                        <div class="font-semibold text-sm">
                                            Diskon
                                        </div>
                                        <input class="border border-gray-300 rounded-md py-2 px-3 ml-2 w-20"
                                            type="text" value="0%">
                                    </div>
                                    <h2 class="font-semibold text-lg">200</h2>
                                </div>

                                <div class="flex justify-between items-center mb-3">
                                    <div class="flex items-center">
                                        {{-- checbox --}}
                                        <input checked class="form-checkbox h-5 w-5 text-blue-600 mr-3" type="checkbox">
                                        <div class="font-semibold text-sm">
                                            PPN
                                        </div>
                                    </div>
                                    <h2 class="font-semibold text-lg">200</h2>
                                </div>
                                <hr class="mb-2">
                                <div class="">
                                    <div class="font-semibold text-sm text-end">Sub Total</div>
                                    <h2 class="font-semibold text-3xl text-red-500  text-end">200</h2>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="form-label font-semibold" for="exampleFormControlInput1">Jumlah
                                        Uang</label>
                                    <div class="flex justify-between items-center">
                                        <input class="form-control border border-gray-300 rounded-md py-2 px-3"
                                            id="scann" placeholder="Jumlah Uang" type="text">
                                        <h2 class="font-semibold text-2xl ml-3">0</h2>
                                    </div>
                                </div>
                                <hr class="mt-2 mb-2">
                                {{-- tombol simpan --}}
                                <div class="flex justify-between items-center mt-3">
                                    <button class="btn btn-success w-full" type="button"><i class='bx bx-check'></i>
                                        SELESAI</button>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function incrementQty(e) {
            let input = e.parentElement.querySelector('input');
            input.value = parseInt(input.value) + 1;
        }

        function decrementQty(e) {
            let input = e.parentElement.querySelector('input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
        $('#loadings').removeClass('hidden');
        // $('#scann').addClass('border-red-500');
        // Definisikan removeFromArray di luar alpine:init event

        function removeFromArray(array, item) {
            const index = array.indexOf(item);
            if (index !== -1) {
                array.splice(index, 1);
            }
        }

        document.addEventListener('alpine:init', () => {
            window.Alpine.data('prodOrder', () => ({
                prodOrder: [],
                addToProdOrder(prod) {
                    this.prodOrder.push(prod);
                },
                removeFromProdOrder(prod) {
                    removeFromArray(this.prodOrder, prod);
                }
            }));
        });
    </script>
@endpush
