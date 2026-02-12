<ul class="nav">
    <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
    </li>

    {{-- MENU KHUSUS ADMIN / KASI --}}
    @if(auth()->user()->role == 'admin')
        <li class="nav-header">OTORITAS & MASTER</li>
        <li class="nav-item">
            <a href="{{ route('jaksa.index') }}" class="nav-link">Data Jaksa (JPN)</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('perkara.create') }}" class="nav-link">Registrasi Perkara Baru</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">Manajemen User (Staff)</a>
        </li>
        <li class="nav-header">OUTPUT</li>
        <li class="nav-item">
            <a href="{{ route('laporan.analitis') }}" class="nav-link">Laporan Analitis PDF</a>
        </li>
    @endif

    {{-- MENU KHUSUS STAFF --}}
    @if(auth()->user()->role == 'staff')
        <li class="nav-header">OPERASIONAL STAFF</li>
        <li class="nav-item">
            <a href="{{ route('perkara.index') }}" class="nav-link">Pantauan & Update</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('perkara.pusat-arsip') }}" class="nav-link">Verifikasi & Akurasi</a>
        </li>
    @endif
</ul>