<!-- Page Sidebar Start-->
<div class="sidebar-wrapper" data-sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper"><a href="index.html"><img class="img-fluid for-light"
                    src="{{ asset('') }}assets/images/logo/logo.png" alt=""><img class="img-fluid for-dark"
                    src="{{ asset('') }}assets/images/logo/logo_dark.png" alt=""></a>
            <div class="back-btn"><i class="fa-solid fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
            </div>
        </div>
        <div class="logo-icon-wrapper"><a href="index.html"><img class="img-fluid"
                    src="{{ asset('') }}assets/images/logo/logo-icon.png" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="index.html"><img class="img-fluid"
                                src="{{ asset('') }}assets/images/logo/logo-icon.png" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa-solid fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li class="pin-title sidebar-main-title">
                        <div>
                            <h6>Pinned</h6>
                        </div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan-1">General</h6>
                        </div>
                    </li>

                    @php
                        $role = Auth::user()->getRoleNames()->first(); // Ambil role pertama user
                    @endphp

                    <li class="sidebar-list">
                        <i class="fa-solid fa-thumbtack"></i>
                        <a class="sidebar-link sidebar-title link-nav"
                            href="{{ route('dashboard.role', ['role' => $role]) }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    @if ($role === 'admin')
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Master</h6>
                            </div>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="/admin/kategori">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#stroke-sample-page"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#fill-sample-page"></use>
                                </svg>
                                <span>Kategori</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="/admin/fakultas">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#stroke-sitemap"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#fill-sitemap"></use>
                                </svg>
                                <span>Fakultas</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="/admin/jurusan">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#stroke-learning"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#fill-learning"></use>
                                </svg>
                                <span>Jurusan</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <a class="sidebar-link sidebar-title link-nav"
                                href="{{ route('custommer-service.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#stroke-user"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#fill-user"></use>
                                </svg>
                                <span>Custommer Service</span>
                            </a>
                        </li>
                    @endif

                    <li class="sidebar-main-title">
                        <div>
                            <h6>Operational</h6>
                        </div>
                    </li>
                    @if ($role === 'dosen')
                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use>
                                </svg>
                                <span>Dokumen</span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('dokumen.index') }}">Pribadi</a></li>
                                <li><a href="{{ route('dokumen.index', ['filter' => 'bimbingan']) }}">Mahasiswa
                                        Bimbingan</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('dokumen.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#stroke-file"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#fill-file"></use>
                                </svg>
                                <span>Dokumen</span>
                            </a>
                        </li>
                    @endif


                    @if ($role === 'admin')
                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <a class="sidebar-link sidebar-title link-nav"
                                href="{{ route('documents.verifikasi.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#stroke-ui-kits"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#fill-ui-kits"></use>
                                </svg>
                                <span>Verifikasi</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ route('spk.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#stroke-charts"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#fill-charts"></use>
                                </svg>
                                <span>SPK PROMETHEE</span>
                            </a>
                        </li>
                    @elseif ($role === 'dosen')
                        <li class="sidebar-list">
                            <i class="fa-solid fa-thumbtack"></i>
                            <a class="sidebar-link sidebar-title link-nav"
                                href="{{ route('dosen.documents.verifikasi.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#stroke-ui-kits"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#fill-ui-kits"></use>
                                </svg>
                                <span>Verifikasi</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<!-- Page Sidebar Ends-->
