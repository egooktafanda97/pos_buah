@extends('Template.layout')
@push('style')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js.map"></script>
    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        referrerpolicy="no-referrer" rel="stylesheet" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.2/axios.min.js"
        integrity="sha512-JSCFHhKDilTRRXe9ak/FJ28dcpOJxzQaCd3Xg8MyF6XFjODhy/YMCM8HW0TFDckNHWUewW+kfvhin43hKtJxAw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
        collections: [],
        token: `{{ !empty(auth()->user()) ? auth()->guard('api')->login(auth()->user()) : null }}`,
        collection: {},
        prodSerach: [],
        searchQuery: '',
        prodOrder: [],
        searchProdukMethod: 'brcode',
        totalOrder: 0,
        diskon: 0,
        init: null,
        init_pph: 0,
        pph: 0,
        orders: [],
        user: {},
        totalPembayaran: 0,
        exeevn: '0',
        addToProdOrder(prod) {
            if (this.prodOrder.find(item => item.id == prod.id) == undefined) {
                prod.qty = 1;
                this.prodOrder.push(prod);
                console.log('po', JSON.stringify(this.prodOrder));
                this.totalOrder = this.prodOrder.reduce((acc, item) => acc + (item.harga_init * item.qty), 0);
                this.searchQuery = '';
                this.prodSerach = [];
                this.orders.push({
                    id: prod.id,
                    qty: 1,
                    harga: prod.harga_init,
                    satuan: prod.satuan_init
                });
            }
        },
        removeFromProdOrder(prod) {
            this.prodOrder = this.prodOrder.filter(item => item.id !== prod.id);
            this.totalOrder = this.prodOrder.reduce((acc, item) => acc + (item.harga_init * item.qty), 0);
            this.orders = this.orders.filter(item => item.id !== prod.id);
        },
        formatRupiah(value) {
            if (typeof value !== 'number') {
                value = parseFloat(value) || 0;
            }
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(value);
        },
        fetchingProd() {
            fetch(`/api/produk/search/${this.searchQuery}`)
                .then(response => response.json())
                .then(data => {
                    if (this.searchProdukMethod == 'brcode' && data.length == 1) {
                        console.log('data', data[0]);
                        this.addToProdOrder(data[0]);
                    } else {
                        this.prodSerach = data;
                    }
                })
                .catch(error => this.prodSerach = [])
        },
        sumSubTotal() {
            var total = 0;
            total = this.orders.reduce((acc, item) => acc + (item.harga * item.qty), 0);
            total = total - (total * (this.diskon / 100));
            total = total + (total * (this.pph / 100));
    
            return total;
        },
        collectData() {
            this.collection = {
                user: this.user,
                orders: this.orders,
                total: this.sumSubTotal(),
                diskon: this.diskon,
                pph: this.pph,
                total_pembayaran: this.totalPembayaran
            };
            return this.collection;
        }
    }" x-init="() => {
        this.exeevn = 0;
        fetch('/api/trx/init-trx', {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer {{ !empty(auth()->user()) ? auth()->guard('api')->login(auth()->user()) : null }}`,
                }
            })
            .then(response => response.json())
            .then(data => {
                init = data;
                try {
                    init_pph = init.config.find(item => item.key == 'pph').value;
                } catch (error) {
                    init_pph = 0;
                }
                pph = init_pph;
            })
            .catch(error => console.error(error));
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
                            <li aria-current="page" class="breadcrumb-item active">KASIR</li>
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
                                    <input @keydown.enter="fetchingProd" class="form-control" id="scann"
                                        placeholder="Cari Produk" type="text" x-model="searchQuery">
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
                                            <div class="bg-gray-50 shadow-sm p-2 flex items-center hover:bg-gray-100 active:bg-gray-300"
                                                style="cursor:pointer" x-on:click="addToProdOrder(prod)">
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
                            <h3 class=" m-1 font-semibold text-lg" x-show="prodOrder.length > 0">Produk Order</h3>
                            {{-- <hr class="m-1"> --}}
                            <div class=" p-2 rounded-md shadow-md m-1" x-show="prodOrder.length > 0">
                                <template :key="prod.id" x-for="prod in prodOrder">
                                    <div class="flex items-center p-4 bg-white rounded-lg" x-data="{
                                        harga: prod.harga_init,
                                        satuan: prod.satuan_init,
                                        qty: prod.qty,
                                        total: prod.harga_init,
                                        updateSatuanNharga(val) {
                                            const hargaItem = prod.harga.find(item => item.jenis_satuan.id == val);
                                            this.harga = hargaItem.harga;
                                            this.satuan = hargaItem.jenis_satuan.id;
                                            this.total = this.harga * this.qty;
                                            this.orders = this.orders.map(item => {
                                                if (item.id == prod.id) {
                                                    item.qty = this.qty;
                                                    item.harga = this.harga;
                                                    item.satuan = this.satuan;
                                                }
                                                return item;
                                            });
                                        },
                                        incrementQty() {
                                            this.qty = parseInt(this.qty) + 1;
                                            this.total = this.harga * this.qty;
                                            this.orders = this.orders.map(item => {
                                                if (item.id == prod.id) {
                                                    item.qty = this.qty;
                                                    item.harga = this.harga;
                                                    item.satuan = this.satuan;
                                                }
                                                return item;
                                            });
                                        },
                                        decrementQty() {
                                            if (parseInt(this.qty) > 1) {
                                                this.qty = parseInt(this.qty) - 1;
                                                this.total = this.harga * this.qty;
                                                this.orders = this.orders.map(item => {
                                                    if (item.id == prod.id) {
                                                        item.qty = this.qty;
                                                        item.harga = this.harga;
                                                        item.satuan = this.satuan;
                                                    }
                                                    return item;
                                                });
                                            }
                                        }
                                    }">
                                        {{-- <img alt="Produk Image" class="w-10 h-10 rounded-lg" src=""> --}}
                                        <div class="flex-1 flex flex-col">
                                            <span class="font-semibold text-md text-gray-800"
                                                x-text="prod.nama_produk"></span>
                                            <div class="flex items-center">
                                                <span class="text-sm text-gray-500 mr-5"
                                                    x-text="formatRupiah(harga)"></span>
                                                <select
                                                    class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                    x-on:change="updateSatuanNharga($event.target.value)">
                                                    <option value="">Pilih Satuan</option>
                                                    <template :key="hargaItem.id" x-for="hargaItem in prod.harga">
                                                        <option :selected="hargaItem.jenis_satuan.id == satuan"
                                                            :value="hargaItem.jenis_satuan.id"
                                                            x-text="hargaItem.jenis_satuan.nama"></option>
                                                    </template>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <div class="flex items-center border border-gray-300 rounded-md">
                                                <button class="px-2 py-1" x-on:click="decrementQty()">-</button>
                                                <input class="w-12 text-center border-l border-r border-gray-300" readonly
                                                    type="text" value="1" x-model="qty">
                                                <button class="px-2 py-1" x-on:click="incrementQty()">+</button>
                                            </div>
                                            <div class="text-lg font-semibold text-gray-800" x-text="formatRupiah(total)">
                                            </div>
                                            <button class="text-red-500 hover:underline"
                                                x-on:click="removeFromProdOrder(prod)">
                                                <i class="fa fa-remove text-xl"></i>
                                            </button>
                                        </div>
                                    </div>

                                </template>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-2 rounded-md shadow-md m-1">
                                <div class="max-w-lg mx-auto mb-5" x-data="{
                                    searchQueryUser: '',
                                    listUser: [],
                                    loading: false,
                                    userSearch() {
                                        fetch(`/api/pelanggan/search?q=${this.searchQueryUser}`, {
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'Authorization': `Bearer {{ !empty(auth()->user()) ? auth()->guard('api')->login(auth()->user()) : null }}`,
                                                }
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                this.loading = false;
                                                this.listUser = data;
                                            })
                                            .catch(error => {
                                                this.prodSerach = []
                                                this.loading = false;
                                            })
                                    },
                                }">
                                    <div class="form-group mb-3 relative">
                                        <label class="form-label font-semibold" for="exampleFormControlInput1">Nomor
                                            Pelanggan</label>
                                        <div class="flex items-center">
                                            <input @keydown.enter="userSearch"
                                                class="form-control border border-gray-300 rounded-md py-2 px-3 flex-1"
                                                id="scann" placeholder="Cari Produk" type="text"
                                                x-model="searchQueryUser">
                                            <div class="ml-2" id="loadings" x-show="loading">
                                                <i class="fas fa-spinner fa-spin text-gray-500"></i>
                                            </div>
                                        </div>
                                        <div class="hidden text-red-500 text-sm mt-2" id="error-message">Pelanggan tidak
                                            ditemukan.</div>
                                        <div class="absolute mt-20 z-50 inset-0" x-show="listUser.length > 0">
                                            <template :key="users.id" x-for="users in listUser">
                                                <div class="bg-gray-50 shadow-sm p-2 flex items-center hover:bg-gray-100 active:bg-gray-300"
                                                    style="cursor:pointer"
                                                    x-on:click="(()=>{
                                                    user =  users;
                                                    searchQueryUser = users.nama_pelanggan;
                                                    listUser = [];
                                                })">
                                                    <div class="flex-1 pl-2 mr-16">
                                                        <div class="text-sm">
                                                            <div class="flex flex-col">
                                                                <div class="text-sm" x-text="users.nama_pelanggan"></div>
                                                                <div class="text-sm"
                                                                    x-text="users.nomor_telepon_pelanggan"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mb-2">
                                <div class="flex justify-between items-center mb-3">
                                    <div class="flex items-center">
                                        <div class="font-semibold text-sm">
                                            Diskon
                                        </div>
                                        <input class="border border-gray-300 rounded-md py-2 px-3 ml-2 w-20"
                                            type="number" x-model="diskon"
                                            x-on:keyup="(()=>{
                                                totalOrder = prodOrder.reduce((acc, item) => acc + (item.harga_init * item.qty), 0);
                                                totalOrder = totalOrder - (totalOrder * (diskon / 100));
                                            })">
                                        <span class="ml-2 text-lg">%</span>
                                    </div>
                                    <h2 class="font-semibold text-lg">0</h2>
                                </div>

                                <div class="flex justify-between items-center mb-3">
                                    <div class="flex items-center">
                                        {{-- checbox --}}
                                        <input checked class="form-checkbox h-5 w-5 text-blue-600 mr-3" type="checkbox"
                                            x-on:change="((e)=>{
                                            totalOrder = prodOrder.reduce((acc, item) => acc + (item.harga_init * item.qty), 0);
                                            totalOrder = totalOrder - (totalOrder * (diskon / 100));
                                            pph = e.target.checked ? init_pph : 0;
                                            totalOrder = totalOrder + (totalOrder * (pph / 100));
                                        })">
                                        <div class="font-semibold text-sm">
                                            pph
                                        </div>
                                    </div>
                                    <h2 class="font-semibold text-lg" x-text="`${pph}%`">
                                        0</h2>
                                </div>
                                <hr class="mb-2">
                                <div class="">
                                    <div class="font-semibold text-sm text-end">Sub Total</div>
                                    <h2 class="font-semibold text-3xl text-red-500  text-end"
                                        x-text="formatRupiah(sumSubTotal())">0</h2>
                                </div>

                                <div class="form-group mt-3" x-data="{
                                    uangPelanggan: 0,
                                    sisaUang: 0,
                                    setUangPelanggan() {
                                        this.totalPembayaran = this.uangPelanggan;
                                        this.sisaUang = this.uangPelanggan - sumSubTotal();
                                    }
                                }">
                                    <label class="form-label font-semibold" for="exampleFormControlInput1">Jumlah
                                        Uang</label>
                                    <div class="flex flex-col items-center">
                                        <input class="form-control border border-gray-300 rounded-md py-2 px-3"
                                            id="scann" placeholder="Jumlah Uang" type="text"
                                            x-model="uangPelanggan" x-on:keyUp="setUangPelanggan">
                                        <h2 class="font-semibold text-2xl ml-3" x-text="formatRupiah(sisaUang)">0</h2>
                                    </div>
                                </div>
                                <hr class="mt-2 mb-2">
                                {{-- tombol simpan --}}
                                <div class="flex justify-between items-center mt-3" x-data="{ invoice: '' }">
                                    <button class="btn btn-success w-full" type="button"
                                        x-on:click="async()=>{
                                            if(this.exeevn === 0){
                                                this.exeevn = 1;
                                                const data = collectData();
                                                const response =  await axios.post('/api/trx/shop',data,{
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'Authorization': `Bearer {{ !empty(auth()->user()) ? auth()->guard('api')->login(auth()->user()) : null }}`,
                                                }
                                            }).catch(error => {
                                                swal({
                                                    title: 'Error!',
                                                    text: error.response?.data?.msg,
                                                    icon: 'error',
                                                    button: 'OK',
                                                });
                                            });

                                            if(response.status == 200){
                                                this.invoice = data?.data?.invoice ?? '';
                                                swal({
                                                        title: 'Success!',
                                                        text: 'Faktur telah berhasil dibuat.',
                                                        icon: 'success',
                                                        buttons: {
                                                            clear: {
                                                                text: 'Clear',
                                                                value: 'clear',
                                                            },
                                                            print: {
                                                                text: 'Print Faktur',
                                                                value: 'print',
                                                            },
                                                        },
                                                    }).then((value) => {
                                                        switch (value) {
                                                            case 'clear':
                                                                location.reload();
                                                                break;
                                                            case 'print':
                                                            openPrintWindow(response.data.data.invoice ?? '');
                                                            location.reload();
                                                                break;
                                                            default:
                                                                break;
                                                        }
                                                    });
                                            }
                                            }
                                        }">
                                        <i class='bx bx-check'></i>SELESAI</button>
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
        $('#loadings').removeClass('hidden');
        // $('#scann').addClass('border-red-500');
        // Definisikan removeFromArray di luar alpine:init event
        function openPrintWindow($inv) {
            const printWindow = window.open(`{{ url('trx/faktur') }}/${$inv}`, 'PrintWindow', 'width=800,height=600');
            printWindow.focus();
        }
    </script>
@endpush
