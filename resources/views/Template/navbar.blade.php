<ul class="metismenu" id="menu">
    <li class="menu-label">MENU</li>
    <li>
        <a href="/home">
            <div class="parent-icon"><i class='bx bx-home-circle'></i>
            </div>
            <div class="menu-title">DASHBOARD</div>
        </a>
    </li>
    @role('toko')
        <li>
            <a href="/produk">
                <div class="parent-icon"><i class='bx bxs-package'></i>
                </div>
                <div class="menu-title">PRODUK BUAH</div>
            </a>
        </li>

        <li>
            <a href="/jenis">
                <div class="parent-icon"><i class='bx bxs-component'></i>
                </div>
                <div class="menu-title">JENIS PRODUK</div>
            </a>
        </li>
        <li>
            <a href="/supplier">
                <div class="parent-icon"><i class='bx bxs-user-detail'></i>
                </div>
                <div class="menu-title">SUPPLIER</div>
            </a>
        </li>

        <li>
            <a href="/satuan">
                <div class="parent-icon"><i class='bx bx-dumbbell'></i>
                </div>
                <div class="menu-title">JENIS SATUAN</div>
            </a>
        </li>
        <li>
            <a href="/pelanggan">
                <div class="parent-icon"><i class='bx bxs-user-pin'></i>
                </div>
                <div class="menu-title">PELANGGAN</div>
            </a>
        </li>
        <li>
            <a href="/harga">
                <div class="parent-icon"><i class='bx bxs-dollar-circle'></i>
                </div>
                <div class="menu-title">HARGA</div>
            </a>
        </li>
        <li>
            <a href="/kasir">
                <div class="parent-icon"><i class='bx bxs-user'></i>
                </div>
                <div class="menu-title">USER KASIR</div>
            </a>
        </li>
        <li>
            <a href="/barangmasuk">
                <div class="parent-icon"><i class='bx bxs-package'></i>
                </div>
                <div class="menu-title">BARANG MASUK</div>
            </a>
        </li>
        <li>
            <a href="/rak">
                <div class="parent-icon"><i class='bx bxl-stack-overflow'></i>
                </div>
                <div class="menu-title">RAK</div>
            </a>
        </li>
    @endrole
    @role('super-admin')
        <li>
            <a href="/toko">
                <div class="parent-icon"><i class='bx bxs-store-alt'></i>
                </div>
                <div class="menu-title">TOKO</div>
            </a>
        </li>
    @endrole
    @role('root')
        <li>
            <a href="/paymenttype">
                <div class="parent-icon"><i class='bx bxs-wallet'></i>
                </div>
                <div class="menu-title">PAYMENT TYPE</div>
            </a>
        </li>
    @endrole
    @role('kasir')
        <li>
            <a href="{{ url('trx') }}">
                <div class="parent-icon">
                    <i class='bx bxs-notepad'></i>
                </div>
                <div class="menu-title">KASIR</div>
            </a>
        </li>
        <li>
            <a href="{{ url('trx/history') }}">
                <div class="parent-icon"><i class='bx bxs-wallet'></i>
                </div>
                <div class="menu-title">HISTORY</div>
            </a>
        </li>
    @endrole

    <li class="menu-label">LAPORAN</li>
    <li>
        <a href="/laporanbarangmasuk">
            <div class="parent-icon"><i class='bx bx-note'></i>
            </div>
            <div class="menu-title">BARANG MASUK</div>
        </a>
    </li>
    <li>
        <a href="/laporanbarangkeluar">
            <div class="parent-icon"><i class='bx bx-note'></i>
            </div>
            <div class="menu-title">BARANG KELUAR</div>
        </a>
    </li>


    <li class="menu-label">AUTH</li>
    <li>
        <a href="/logout">
            <div class="parent-icon"><i class='bx bx-power-off'></i>
            </div>
            <div class="menu-title">LOGOUT</div>
        </a>
    </li>
</ul>
