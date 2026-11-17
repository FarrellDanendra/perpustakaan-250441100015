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
            <div style="background-color: #dcfce7; color: #15803d; padding: 14px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.05);" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 14px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.05);" role="status">
                {{ session('error') }}
            </div>
        @endif

        @can('kelola-buku')
            <div style="margin-bottom: 24px;">
                <a href="{{ route('buku.create') }}"
                    style="background-color: #4f46e5; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);">
                    <span>+</span> Tambah Buku Baru
                </a>
            </div>
        @endcan

        <div id="book-grid" class="book-grid">
            @forelse ($books as $book)
                <div class="book-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="{{ min($loop->index * 150, 600) }}">
                    <div class="book-card-content">
                        <span class="book-category">{{ $book->kategori->nama ?? 'Umum' }}</span>
                        <h2>{{ $book->judul }}</h2>
                        <p class="book-author"><strong>Penulis:</strong> {{ $book->penulis }}</p>
                        <p class="book-year"><strong>Tahun:</strong> {{ $book->tahun_terbit }}</p>
                        <a href="{{ route('buku.show', $book->id) }}" class="btn-detail" style="display: inline-block; margin-top: 10px;">
                            Lihat Detail →
                        </a>
                    </div>
                    
                    <div class="book-card-footer" style="margin-top: 18px; padding-top: 14px; border-top: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 10px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <small style="color: #64748b; font-weight: 600;">ID: {{ $book->id }}</small>
                            
                            {{-- Tombol Ajukan Peminjaman untuk semua role --}}
                            <form action="{{ route('peminjaman.store', $book->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Ajukan peminjaman buku: {{ $book->judul }}?');"
                                    style="background-color: #4f46e5; color: white; padding: 6px 14px; border-radius: 6px; border: none; cursor: pointer; font-size: 0.825rem; font-weight: 600; transition: background 0.2s;">
                                    Ajukan Peminjaman
                                </button>
                            </form>
                        </div>

                        {{-- Tombol Edit & Hapus khusus Admin dan Petugas --}}
                        @can('kelola-buku')
                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                <a href="{{ route('buku.edit', $book->id) }}"
                                    style="background-color: #f59e0b; color: white; padding: 5px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; font-weight: 600;">
                                    Edit
                                </a>
                                <form action="{{ route('buku.destroy', $book->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus buku ini?');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="background-color: #ef4444; color: white; padding: 5px 12px; border-radius: 6px; border: none; cursor: pointer; font-size: 0.8rem; font-weight: 600;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            @empty
                <p style="grid-column: 1 / -1; text-align: center; color: #64748b; padding: 40px;">Belum ada data buku.</p>
            @endforelse
        </div>
    </div>
@endsection