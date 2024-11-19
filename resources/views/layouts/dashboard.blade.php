<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets/') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Article's</title>
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>

    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-container {
            z-index: 9999 !important;
        }

        .dot {
            height: 11px;
            width: 11px;
            background-color: rgb(68, 68, 249);
            border-radius: 50%;
            display: inline-block;
        }

        .vl {
            border-left: 2px solid #E4E6E8;
            margin-right: 10px;
        }
    </style>
    <script type="text/javascript">
        function showToast(title, text, icon) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: title,
                text: text,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: () => {
                    const toast = Swal.getToast();
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        }

        $(document).ready(function() {
            // Event handler untuk tombol delete
            $('button[id^="deleteButton"]').on('click', function(e) {
                e.preventDefault();

                // Mengambil ID form dari tombol yang diklik
                var formId = $(this).closest('form').attr('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form jika user mengonfirmasi penghapusan
                        $('#' + formId).submit();
                    }
                });
            });
        });
    </script>
    {{-- Sweetalert --}}

    {{-- AOS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Gaya kustom untuk Select2 */
        .select2-container .select2-selection--single {
            border: 1px solid #D9DEE3;
            border-radius: 4px;
            padding: 7px;
            height: 40px;
        }

        .select2-results__option:hover {
            background-color: #5F61E6;
            /* Warna latar belakang saat hover */
            color: #fff;
            /* Warna teks saat hover */
        }

        .select2-dropdown {
            max-height: 200px;
            overflow-y: scroll;
        }
    </style>
</head>

<body>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('backend.sidebar')

            <div class="layout-page">
                @include('backend.header', ['user' => auth()->user()])

                <div class="content-wrapper">
                    @yield('content')
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.j') }}s"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="../assets/js/ui-modals.js"></script>
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

    <!-- Datatables JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/dt-2.1.5/b-3.1.2/b-html5-3.1.2/r-3.0.3/sc-2.4.3/sb-1.8.0/datatables.min.js">
    </script>
    <script>
        let table = new DataTable('#myTable');
    </script>

    {{-- aos --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    {{-- Select2 --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#defaultSelect').select2({
                theme: 'custom' // opsional: menyesuaikan dengan tema bootstrap4
            });
        });
    </script>

    {{-- tinymce --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.4.1/tinymce.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: '#exampleFormControlTextarea2',
                height: 500, // Anda bisa menyesuaikan tinggi awal
                toolbar: 'undo redo | styles | bold italic | bullist numlist | alignleft aligncenter alignright | outdent indent',
                plugins: 'lists link image',
                setup: function(editor) {
                    editor.on('init', function() {
                        editor.getBody().style.width = '100%';
                    });

                    // Menyesuaikan tinggi editor berdasarkan isi
                    editor.on('input', function() {
                        editor.getBody().style.height =
                            'auto'; // Set height to auto before getting scrollHeight
                        editor.getBody().style.height = (editor.getBody().scrollHeight) +
                            'px'; // Set height to scrollHeight
                    });
                },
            });
        });
    </script>

    <script>
        document.getElementById('formFile').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Ambil file dari input
            const previewImage = document.getElementById('previewImage'); // Referensi elemen img

            if (file) {
                const reader = new FileReader();

                // Saat file selesai dibaca
                reader.onload = function(e) {
                    previewImage.src = e.target.result; // Setel sumber gambar ke data URL
                    previewImage.style.display = 'block'; // Tampilkan elemen gambar
                };

                reader.readAsDataURL(file); // Baca file sebagai data URL
            } else {
                previewImage.src = '#'; // Reset preview jika tidak ada file
                previewImage.style.display = 'none'; // Sembunyikan elemen gambar
            }
        });
    </script>

    {{-- checkbox di role --}}
    <script>
        $(document).ready(function() {
            // Event listener untuk semua checkbox
            $('.permission-checkbox').on('change', function() {
                var group = $(this).data('group'); // Ambil kategori (misal 'role')
                var type = $(this).data('type'); // Ambil tipe (misal 'list', 'create', dll)

                // Jika yang di-check/uncheck adalah tipe 'list'
                if (type === 'list') {
                    var isChecked = $(this).is(':checked');

                    // Check/uncheck checkboxes yang memiliki group sama (misal 'role')
                    $('.permission-checkbox[data-group="' + group + '"]').each(function() {
                        if ($(this).data('type') !== 'list') { // Selain yang 'list'
                            $(this).prop('checked', isChecked);
                        }
                    });
                }
            });
        });
    </script>

    <script>
        document.getElementById('notification-bell').addEventListener('click', function() {
            // Kirim permintaan ke server untuk menandai semua notifikasi sebagai dibaca
            fetch("{{ route('notifications.markAsRead') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Ubah badge menjadi kosong (menghilangkan jumlah notifikasi baru)
                        document.querySelector('#notification-bell .badge').textContent = '';
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

    {{-- paginaation user --}}

    @yield('scripts')
</body>

</html>
