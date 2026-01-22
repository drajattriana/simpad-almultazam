<div class="main-header" data-background-color="purple">
    <!-- Logo Header -->
    <div class="logo-header">
        <a href="index.html" class="logo" style="color: white;">
            <img src="<?=  base_url('assets/img/logo.png') ?>" alt="navbar brand" class="navbar-brand" width="15%">
            &ensp;AL-MULTAZAM
        </a>

        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="fa fa-bars"></i>
            </span>
        </button>

        <button class="topbar-toggler more"><i class="fa fa-ellipsis-v"></i></button>

        <div class="navbar-minimize">
            <button class="btn btn-minimize btn-rounded">
                <i class="fa fa-bars"></i>
            </button>
        </div>
    </div>
    <!-- End Logo Header -->

    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <!-- Placeholder kiri (bisa isi search atau breadcrumb nanti) -->
            <div class="d-none d-lg-block"></div>
            <style>
                /* CHIP LICENSE (inline, tanpa edit file CSS lain) */
                .license-label {
                    color: rgba(255, 255, 255, .85);
                    font-weight: 600;
                    letter-spacing: .3px;
                    margin-right: .5rem;
                    font-size: .85rem;
                }

                .license-chip {
                    display: inline-flex;
                    align-items: center;
                    gap: .5rem;
                    padding: .35rem .6rem;
                    border-radius: 999px;
                    font-weight: 600;
                    font-size: .82rem;
                    line-height: 1;
                    background: linear-gradient(180deg, #d1f7df 0%, #b8f0cf 100%);
                    border: 1px solid #9be2b8;
                    color: #0ea133ff;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
                    backdrop-filter: saturate(140%) blur(2px);
                    white-space: nowrap;
                }

                .license-chip .dot {
                    width: .55rem;
                    height: .55rem;
                    border-radius: 50%;
                    background: #087622ff;
                    position: relative;
                    box-shadow: 0 0 0 2px rgba(255, 255, 255, .5) inset;
                    flex: 0 0 .55rem;
                }

                .license-chip .dot::after {
                    content: '';
                    position: absolute;
                    inset: -4px;
                    border-radius: 50%;
                    background: rgba(40, 167, 69, .35);
                    animation: licensePulse 1.8s ease-out infinite;
                }

                @keyframes licensePulse {
                    0% {
                        transform: scale(.6);
                        opacity: .9
                    }

                    70% {
                        transform: scale(1.6);
                        opacity: 0
                    }

                    100% {
                        transform: scale(1.6);
                        opacity: 0
                    }
                }

                .license-chip .text {
                    letter-spacing: .2px;
                    text-shadow: 0 1px 0 rgba(255, 255, 255, .35);
                }

                /* Responsive: sembunyikan label "License" di layar kecil */
                @media (max-width: 576px) {
                    .license-label {
                        display: none;
                    }
                }

                /* Kontras pada header ungu Azzara */
                [data-background-color="purple"] .license-label {
                    color: rgba(255, 255, 255, .9);
                }
            </style>

            <!-- Ganti bagian "License : Active" dengan ini -->
            <div class="d-flex align-items-center ml-auto">
                <span class="license-label">License</span>
                <span class="license-chip" title="Lisensi aktif & tervalidasi">
                    <span class="dot"></span>
                    <span class="text">Active</span>
                </span>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
</div>