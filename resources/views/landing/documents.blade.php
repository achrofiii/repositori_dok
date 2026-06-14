@extends('layouts.landingpage')
@section('content-header')
  <div class="space-100"></div>
  <div class="header-text">
    <div class="container">
      <div class="row wow fadeInUp">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 text-center">
          <div class="jumbotron">
            <h1 class="text-white">Halaman Perpustakaan Dokumen</h1>
          </div>
          <div class="title-bar white">
            <ul class="list-inline list-unstyled">
              <li><i class="icofont icofont-square"></i></li>
              <li><i class="icofont icofont-square"></i></li>
            </ul>
          </div>
          <div class="space-40"></div>
        </div>
        <div class="row wow fadeInUp" data-wow-delay="0.5s">
          <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 ">
            <div class="panel">
              <div class="panel-heading">
                <ul class="nav nav-tabs" id="searchTabs"> {{-- Tambahkan ID untuk JS --}}
                  {{-- Tab Judul --}}
                  <li class="{{ ($search_type ?? 'judul') == 'judul' ? 'active' : '' }}">
                    <a data-toggle="tab" href="#book">Judul</a>
                  </li>
                  {{-- Tab Abstrak --}}
                  <li class="{{ ($search_type ?? '') == 'abstrak' ? 'active' : '' }}">
                    <a data-toggle="tab" href="#author">Abstrak</a>
                  </li>
                  {{-- Tab Kategori --}}
                  <li class="{{ ($search_type ?? '') == 'kategori' ? 'active' : '' }}">
                    <a data-toggle="tab" href="#publisher">Kategori</a>
                  </li>
                </ul>
              </div>
              <div class="panel-body">
                <div class="tab-content">
                  {{-- Input tersembunyi untuk menyimpan tipe pencarian aktif --}}
                  <input type="hidden" name="search_type" id="hiddenSearchType" value="{{ $search_type ?? 'judul' }}">

                  {{-- Tab Pane Judul --}}
                  <div class="tab-pane fade {{ ($search_type ?? 'judul') == 'judul' ? 'in active' : '' }}" id="book">
                    <form action="{{ route('dokumen.search') }}" method="GET">
                      {{-- Input tersembunyi untuk search_type di setiap form --}}
                      <input type="hidden" name="search_type" value="judul">
                      <div class="input-group">
                        <input type="text" name="judul_query" class="form-control" placeholder="Masukkan Judul dokumen"
                          value="{{ old('judul_query', $judul_query ?? '') }}">
                        <div class="input-group-btn">
                          <button type="submit" class="btn btn-primary">
                            <i class="icofont icofont-search-alt-2"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>

                  {{-- Tab Pane Abstrak --}}
                  <div class="tab-pane fade {{ ($search_type ?? '') == 'abstrak' ? 'in active' : '' }}" id="author">
                    <form action="{{ route('dokumen.search') }}" method="GET">
                      {{-- Input tersembunyi untuk search_type di setiap form --}}
                      <input type="hidden" name="search_type" value="abstrak">
                      <div class="input-group">
                        <input type="text" name="abstrak_query" class="form-control"
                          placeholder="Masukkan Abstrak dokumen" value="{{ old('abstrak_query', $abstrak_query ?? '') }}">
                        <div class="input-group-btn">
                          <button type="submit" class="btn btn-primary">
                            <i class="icofont icofont-search-alt-2"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>

                  {{-- Tab Pane Kategori --}}
                  <div class="tab-pane fade {{ ($search_type ?? '') == 'kategori' ? 'in active' : '' }}" id="publisher">
                    <form action="{{ route('dokumen.search') }}" method="GET">
                      {{-- Input tersembunyi untuk search_type di setiap form --}}
                      <input type="hidden" name="search_type" value="kategori">
                      <div class="input-group">
                        {{-- Ganti input text dengan select dropdown untuk kategori --}}
                        <select name="kategori_id" class="form-control"> {{-- Gunakan form-control untuk styling Bootstrap --}}
                          <option value="">-- Pilih Kategori --</option>
                          @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                              {{ isset($kategori_id) && $kategori_id == $kategori->id ? 'selected' : '' }}>
                              {{ $kategori->nama_kategori }}
                            </option>
                          @endforeach
                        </select>
                        <div class="input-group-btn">
                          <button type="submit" class="btn btn-primary">
                            <i class="icofont icofont-search-alt-2"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="space-100"></div>

  @push('scripts')
    {{-- Pastikan Anda memiliki stack('scripts') di layout utama --}}
    <script>
      $(document).ready(function() {
        // Ambil search_type saat ini dari hidden input untuk set tab aktif saat reload
        var currentSearchType = $('#hiddenSearchType').val();
        if (currentSearchType) {
          // Tentukan ID tab yang harus aktif berdasarkan search_type
          var tabId;
          if (currentSearchType === 'judul') {
            tabId = '#book';
          } else if (currentSearchType === 'abstrak') {
            tabId = '#author';
          } else if (currentSearchType === 'kategori') {
            tabId = '#publisher';
          }

          // Aktifkan tab yang sesuai jika bukan default 'judul'
          if (tabId && currentSearchType !== 'judul') {
            $('a[href="' + tabId + '"]').tab('show');
          }
        }

        // Tangani perubahan tab untuk mengupdate hidden input
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
          var targetTab = $(e.target).attr("href"); // e.g., #book, #author, #publisher
          var searchType;
          if (targetTab === '#book') {
            searchType = 'judul';
          } else if (targetTab === '#author') {
            searchType = 'abstrak';
          } else if (targetTab === '#publisher') {
            searchType = 'kategori';
          }
          $('#hiddenSearchType').val(searchType);
        });
      });
    </script>
  @endpush
@endsection
@section('content')
  <section>
    <div class="space-80"></div>
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-md-10 pull-right">
          <div class="space-20"></div>
          <div class="row">
            @forelse ($dokumen as $document => $item)
              {{-- Pastikan Anda menggunakan $document sebagai nama variabel loop --}}
              {{-- Pastikan Anda menggunakan $item sebagai nama variabel loop --}}
              <div class="col-xs-12 col-md-6">
                <div class="category-item well yellow">
                  <div class="media">
                    <div class="media-left">
                      {{-- MULAI KODE BARU DI SINI --}}
                      @if ($item->thumbnail_path)
                        {{-- Asumsi $item->thumbnail_path sekarang selalu menunjuk ke file gambar (JPG/PNG/dll.) --}}
                        <img width="150px" src="{{ asset('storage/dokumen/thumbnail/' . $item->thumbnail_path) }}"
                          class="media-object" alt="{{ $item->judul }}">
                      @else
                        {{-- Gambar default jika thumbnail_path null atau kosong --}}
                        <img width="150px" src="{{ asset('images/default_thumbnail.png') }}" class="media-object"
                          alt="Tidak Ada Thumbnail">
                      @endif
                      {{-- AKHIR KODE BARU DI SINI --}}
                    </div>
                    <div class="media-body">
                      <h5>{{ $item->judul }}</h5>
                      <h6>{{ $item->kategori->nama_kategori ?? 'Kategori Tidak Diketahui' }}</h6>
                      <h6>{{ $item->tahun_publikasi }}</h6>
                      <div class="space-10"></div>
                      <p>{{ Str::limit($item->abstrak, 150, '...') }}</p>
                      <a href="{{ route('dokumen.download', $item) }}" class="btn btn-primary btn-sm">Unduh
                        ({{ $item->jumlah_diunduh }})
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-xs-12 text-center">
                <p>Tidak ada dokumen yang ditemukan dengan kriteria pencarian.</p>
              </div>
            @endforelse
          </div>
          <div class="space-60"></div>
          <div class="row">
            <div class="col-xs-12">
              <div class="shop-pagination pull-right">
                @if ($dokumen->lastPage() > 1)
                  <div class="custom-pagination" style="margin-top: 20px;">
                    {{-- Tombol First --}}
                    @if (!$dokumen->onFirstPage())
                      <a href="{{ $dokumen->url(1) }}" class="page-link">« First</a>
                    @endif

                    {{-- Tombol Previous --}}
                    @if ($dokumen->previousPageUrl())
                      <a href="{{ $dokumen->previousPageUrl() }}" class="page-link">‹ Prev</a>
                    @endif

                    {{-- Nomor halaman --}}
                    @for ($i = 1; $i <= $dokumen->lastPage(); $i++)
                      @if ($i == $dokumen->currentPage())
                        <span class="page-link current">{{ $i }}</span>
                      @else
                        <a href="{{ $dokumen->url($i) }}" class="page-link">{{ $i }}</a>
                      @endif
                    @endfor

                    {{-- Tombol Next --}}
                    @if ($dokumen->nextPageUrl())
                      <a href="{{ $dokumen->nextPageUrl() }}" class="page-link">Next ›</a>
                    @endif

                    {{-- Tombol Last --}}
                    @if ($dokumen->currentPage() != $dokumen->lastPage())
                      <a href="{{ $dokumen->url($dokumen->lastPage()) }}" class="page-link">Last »</a>
                    @endif
                  </div>
                @endif

              </div>
            </div>
          </div>
        </div>
        <!-- Sidebar-Start -->
        <div class="col-xs-12 col-md-2">
          <aside>
            <h3><i class="icofont icofont-filter"></i> Filter By</h3>
            <div class="space-30"></div>
            <div class="sigle-sidebar">
              <h4>Kategori</h4>
              <hr>
              <ul class="list-unstyled menu-tip">
                <li>
                  <a href="{{ route('landingpage.documents')}}"
                    class="{{ request('kategori_id') == '' ? 'fw-bold text-primary' : '' }}">
                    Semua Kategori
                  </a>
                </li>
                @foreach ($kategoris as $kategori)
                  <li>
                    <a href="{{ request()->fullUrlWithQuery(['kategori_id' => $kategori->id]) }}"
                      class="{{ request('kategori_id') == $kategori->id ? 'fw-bold text-primary' : '' }}">
                      {{ $kategori->nama_kategori }}
                    </a>
                  </li>
                @endforeach
              </ul>

              {{-- <a href="#" class="btn btn-primary btn-xs">See All</a> --}}
            </div>
          </aside>
        </div>
        <!-- Sidebar-End -->
      </div>
    </div>
    <div class="space-80"></div>
  </section>
@endsection
