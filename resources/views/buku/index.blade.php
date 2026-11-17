@extends('layouts.app')
@section('title', 'Daftar Buku')
@section('content')
    <div class="book-page">
        <div class="page-header" data-aos="fade-down" data-aos-duration="800" data-aos-delay="100">
            <span class="page-label">KOLEKSI PERPUSTAKAAN</span>
            <h1>Daftar Buku</h1>
            <p>Jelajahi koleksi buku yang tersedia di perpustakaan.</p>
        </div>

        @if (session('success'))
            <div style="background-color: #dcfce7; color: #15803d; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;" role="status">
                {{ session('error') }}
            </div>
        @endif

        {{-- Tombol Tambah Buku hanya muncul untuk Admin/Petugas (Gate kelola-buku) --}}
        @can('kelola-buku')
            <div style="margin-bottom: 20px;">
                <a href="{{ route('buku.create') }}"
                    style="background-color: #4f46e5; color: white; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block;">
                    + Tambah Buku Baru
                </a>
            </div>
        @endcan

        <div id="book-grid" class="book-grid">
            @forelse ($books as $book)
                <div class="book-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="{{ min($loop->index * 150, 600) }}">
                    <div class="book-card-content">
                        <span class="book-category">{{ $book->kategori->nama ?? 'Umum' }}</span>
                        <h2>{{ $book->judul }}</h2>
                        <p class="book-author">Penulis: {{ $book->penulis }}</p>
                        <p class="book-year">Tahun Terbit: {{ $book->tahun_terbit }}</p>
                        <a href="{{ route('buku.show', $book->id) }}" class="btn-detail" style="display: inline-block; margin-top: 10px;">Lihat Detail</a>
                    </div>
                    
                    <div class="book-card-footer" style="margin-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                        <small style="color: #64748b; font-weight: 600;">ID: {{ $book->id }}</small>
                        
                        <div style="display: flex; gap: 8px;">
                            @can('kelola-buku')
                                <form action="{{ route('buku.destroy', $book->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus buku ini?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="background-color: #ef4444; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; font-size: 0.875rem;">
                                        Hapus
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                <p style="grid-column: 1 / -1; text-align: center; color: #64748b; padding: 40px;">Belum ada data buku.</p>
            @endforelse
        </div>
    </div>
@endsection