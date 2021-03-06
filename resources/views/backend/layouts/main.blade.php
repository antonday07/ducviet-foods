<!DOCTYPE html>
<html lang="zxx" class="js">

<head>

    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>Admin Area</title>
    <!-- StyleSheets  -->
    <link id="skin-default" rel="stylesheet" href="{{ asset('/backend/css/theme.css?ver=2.4.0') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link rel="stylesheet" href="{{ asset('/backend/css/dashlite.css?ver=2.4.0') }}">
    <link rel="stylesheet" href="{{ asset('/backend/css/style.css') }}">
    
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    {{-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script> --}}
    <script src="https://cdn.tiny.cloud/1/awaxf0qyu32cfdki89pxaillzpiyp5f9k4mqrfbf65kysnhr/tinymce/4/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        var editor_config = {
            path_absolute: "http://127.0.0.1:8000/",
            selector: "textarea#detailarea",
            height: 300,
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'table emoticons template paste help'
            ],
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | print preview media fullpage | ' +
                'forecolor backcolor emoticons | help',
            menu: {
                favs: {
                    title: 'My Favorites',
                    items: 'code visualaid | searchreplace | emoticons'
                },
                file: {
                    title: 'File',
                    items: 'newdocument restoredraft | preview | print '
                },
                edit: {
                    title: 'Edit',
                    items: 'undo redo | cut copy paste | selectall | searchreplace'
                },
                view: {
                    title: 'View',
                    items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen'
                },
                insert: {
                    title: 'Insert',
                    items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime'
                },
                format: {
                    title: 'Format',
                    items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align lineheight | forecolor backcolor | removeformat'
                },
                tools: {
                    title: 'Tools',
                    items: 'spellchecker spellcheckerlanguage | code wordcount'
                },
                table: {
                    title: 'Table',
                    items: 'inserttable | cell row column | tableprops deletetable'
                },
                help: {
                    title: 'Help',
                    items: 'help'
                }
            },
            menubar: 'favs file edit view insert format tools table help',
            relative_urls: false,
        };

        tinymce.init(editor_config);

    </script>
    
    @livewireStyles
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    @flasher_render
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            @include('backend.partials.sidebar')
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                @include('backend.partials.main_header')
                <!-- main header @e -->
                <!-- content @s -->
                @yield('content')
                <!-- content @e -->
                <!-- footer @s -->
                @include('backend.partials.footer')
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="{{ asset('/backend/js/bundle.js?ver=2.4.0') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/notify.js')}}"></script>
    <script src="{{ asset('/backend/js/scripts.js?ver=2.4.0') }}"></script>
    <script src="{{ asset('/backend/js/charts/chart-ecommerce.js?ver=2.4.0') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/datatable-basic.init.js') }}"></script>
    <script src="{{ asset('/backend/js/orderStatus.js')}}"></script>
    <script src="{{ asset('/backend/js/custom.js')}}"></script>

        <script>
            window.laravel_echo_port='{{env("LARAVEL_ECHO_PORT")}}';
        </script>
        <script src="//{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script>
        <script src="{{ url('/js/laravel-echo-setup.js') }}" type="text/javascript"></script>
        
        <script type="text/javascript">
            // Listening event when new order coming
            window.Echo.channel('order.coming')
            .listen('.OrderComing', (response) => {
                let url = '{{ route("order.detail", ":id") }}';
                url = url.replace(':id', response.order.id);

                Toastify({
                    text: "C?? m???t ????n h??ng m???i",
                    duration: 5000,
                    destination: url,
                    // newWindow: true,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "#d63031",
                    },
                    onClick: function(){} // Callback after click
                }).showToast();
                console.log(response);
            });

            // Listening event when order change status
            window.Echo.channel('order.status')
            .listen('.TrackingOrder', (response) => {
                let url = '{{ route("order.detail", ":id") }}';

                url = url.replace(':id', response.order.id);

                Toastify({
                    text: response.message,
                    duration: 5000,
                    destination: url,
                    // newWindow: true,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "#d63031",
                    },
                    onClick: function(){} // Callback after click
                }).showToast();
                
            });

        </script>

    @stack('after-scripts')
    @livewireScripts
</body>

</html>
