<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login | SIMPAD Al-Multazam</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="<?= base_url('assets/js/plugin/webfont/webfont.min.js') ?>"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Open+Sans:300,400,600,700"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"],
                urls: ['../assets/css/fonts.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/azzara.min.css') ?>">
</head>

<body class="login">
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn">
            <center><img
                    src="<?= base_url('assets/img/banner.png') ?>"
                    alt="Almultazam"
                    width="80%" /></center> <br>
            <h4 class="text-center">Sign in to start your session</h4> <br>
            <div class="login-form">
                <form action="<?= base_url('auth/login') ?>" method="post">
                    <div class="form-group">
                        <label for="username" class="placeholder"><b>Username</b></label>
                        <input id="username" name="username" type="text" class="form-control" name="username" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="placeholder"><b>Password</b></label>
                        <div class="position-relative">
                            <input id="password" name="password" type="password" class="form-control" name="password" required>
                            <div class="show-password">
                                <i class="flaticon-interface"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-action-d-flex mb-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberme" name="rememberme" value="1">
                            <label class="custom-control-label m-0" for="rememberme">Remember Me</label>
                        </div>
                        <button type="submit" id="btnSignIn" class="btn btn-primary col-md-5 float-right mt-3 mt-sm-0 fw-bold">Sign In</button>
                    </div>
                    <span id="lockoutInfo" class="text-danger ml-2 text-center" style="font-weight:600;"></span> <!-- show lockout countdown -->
                </form>
            </div>
        </div>
    </div>

    <!-- Pemuatan Library JS -->
    <script src="<?= base_url('assets/js/core/jquery.3.2.1.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/core/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/core/bootstrap.min.js') ?>"></script>

    <!-- add bootstrap-notify plugin for login page -->
    <script src="<?= base_url('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') ?>"></script>

    <script src="<?= base_url('assets/js/ready.js') ?>"></script>

    <?php $err = session()->getFlashdata('error') ?? null; ?>
    <div id="error-holder" data-error="<?= esc($err ?? '') ?>" style="display:none;"></div>

    <!-- trigger simple notify on login page -->
    <script>
        // --- Login attempt lockout (client-side only; keeps existing notify untouched) ---
        // Rule: Every 3 consecutive failures -> lock: 1m, 2m, 3m, ...

        (function() {
            var btn = document.getElementById('btnSignIn');
            var info = document.getElementById('lockoutInfo');

            var ATTEMPTS_KEY = 'login_attempts';
            var BLOCK_UNTIL_KEY = 'login_block_until';
            var CYCLE_KEY = 'login_cycle'; // number of completed 3-fail cycles

            function nowMs() {
                return Date.now();
            }

            function getInt(k, d) {
                var v = sessionStorage.getItem(k);
                v = parseInt(v, 10);
                return isNaN(v) ? d : v;
            }

            function setInt(k, v) {
                sessionStorage.setItem(k, String(v));
            }

            function isBlocked() {
                var until = getInt(BLOCK_UNTIL_KEY, 0);
                return until > nowMs();
            }

            function refreshCountdown() {
                var until = getInt(BLOCK_UNTIL_KEY, 0);
                var remain = Math.max(0, until - nowMs());
                if (remain > 0) {
                    var sec = Math.ceil(remain / 1000);
                    info.textContent = 'Wait ' + sec + 's to try again.'; // UI countdown
                    btn.setAttribute('disabled', 'disabled');
                } else {
                    info.textContent = '';
                    btn.removeAttribute('disabled');
                }
            }

            // Enforce state on load
            refreshCountdown();
            var t = setInterval(refreshCountdown, 500);

            // Prevent submit if blocked
            var form = document.querySelector('.login-form form');
            form.addEventListener('submit', function(e) {
                if (isBlocked()) {
                    e.preventDefault(); // block during countdown
                    return;
                }
            });

            // Use server flash error once: clone value into a local variable to avoid double consumption issues
            var flashErrorVal = <?= json_encode(session()->getFlashdata('error') ?? null) ?>; // do NOT remove original notify above
            var flashError = flashErrorVal; // use same value here; no extra getFlashdata calls

            if (flashError) {
                var attempts = getInt(ATTEMPTS_KEY, 0) + 1;
                setInt(ATTEMPTS_KEY, attempts);

                if (attempts >= 3) {
                    var cycle = getInt(CYCLE_KEY, 0) + 1; // progressive minutes
                    setInt(CYCLE_KEY, cycle);

                    var minutes = cycle;
                    var blockMs = minutes * 60 * 1000;
                    setInt(BLOCK_UNTIL_KEY, nowMs() + blockMs);

                    setInt(ATTEMPTS_KEY, 0); // reset after lock
                    refreshCountdown();
                }
            }

            // Clear UI state on success
            var isLogged = <?= json_encode(session()->get('log') ?? false) ?>;
            if (isLogged) {
                sessionStorage.removeItem(ATTEMPTS_KEY);
                sessionStorage.removeItem(BLOCK_UNTIL_KEY);
                sessionStorage.removeItem(CYCLE_KEY);
            }
        })();
    </script>

    <script>
        // Fallback: jika flashError kosong, pakai pesan di data-error DOM
        (function() {
            var el = document.getElementById('error-holder');
            if (!el) return;
            var msg = el.getAttribute('data-error');
            if (msg && msg.trim().length > 0) {
                $.notify({
                    icon: 'flaticon-alarm-1',
                    title: 'Error',
                    message: msg
                }, {
                    type: 'danger',
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    delay: 1000,
                    timer: 1000,
                    mouse_over: 'pause',
                    template: '<div data-notify="container" class="alert alert-{0}" role="alert" ' +
                        'style="max-width:280px; padding:12px 14px; position:relative; cursor:pointer;">' +
                        '<button type="button" class="close" data-notify="dismiss" style="display:none;">&times;</button>' +
                        '<span data-notify="icon" style="margin-right:6px;"></span>' +
                        '<span data-notify="title" style="font-weight:600; margin-right:4px;">{1}</span>' +
                        '<span data-notify="message">{2}</span>' +
                        '</div>'
                });

                // Klik untuk dismiss
                $(document).on('click', '[data-notify="container"]', function(e) {
                    if (!$(e.target).is('a,[data-notify="dismiss"]')) {
                        $(this).find('[data-notify="dismiss"]').trigger('click');
                    }
                });
            }
        })();
    </script>

</body>

</html>