{{-- Jquery --}}
<!-- <script src="{{ asset('assets/js/jquery-3.5.0.min.js') }}"></script> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->


{{-- TinyMCE --}}

{{--<!-- <script src="{{ asset('assets/js/tinymce.min.js') }}" referrerpolicy="origin"></script> -->--}}
{{--<!-- <script src="https://cdn.tiny.cloud/1/nkf4wjrsf6g1am5any6qwcsniq35ahxf0rh9iozbyearhuzq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->--}}
<script src="{{ asset('assets/js/tmce.min.js') }}" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector:'#tinymceEditor',
        setup: function(editor) {
            editor.on('init', function(e) {
                console.log('The Editor has initialized.');
                close_referrer_message();
            });
        },
        plugins : 'visualblocks wordcount directionality advlist autolink link image media lists charmap print preview table code',
        toolbar: 'visualblocks wordcount directionality advlist autolink link image media lists charmap print preview table code',
        directionality : "rtl",
        // skin: "oxide-dark",
        // content_css: "dark",
        toolbar_mode: 'floating',
        height: 500,
        file_picker_callback (callback, value, meta) {
            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
            let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight

            tinymce.activeEditor.windowManager.openUrl({
                url : '/file-manager/tinymce5',
                {{--                url : '{{ route('elfinder.tinymce5') }}',--}}
                title : 'FileManager',
                width : x * 0.8,
                height : y * 0.8,
                onMessage: (api, message) => {
                    callback(message.content, { text: message.text })
                }

                // onMessage: function (dialogApi, details) {
                //     if (details.mceAction === 'fileSelected') {
                //         const file = details.data.file;
                //
                //         // Make file info
                //         const info = file.name;
                //
                //         // Provide file and text for the link dialog
                //         if (meta.filetype === 'file') {
                //             callback(file.url, {text: info, title: info});
                //         }
                //
                //         // Provide image and alt text for the image dialog
                //         if (meta.filetype === 'image') {
                //             callback(file.url, {alt: info});
                //         }
                //
                //         // Provide alternative source and posted for the media dialog
                //         if (meta.filetype === 'media') {
                //             callback(file.url);
                //         }
                //
                //         dialogApi.close();
                //     }
                // }

            })
        }
    });
    // function close_referrer_message() {
    //     document.getElementsByClassName('tox-notification__dismiss')[0].click();
    // }
</script>

<script>
    function elFinderBrowser (callback, value, meta) {
        tinymce.activeEditor.windowManager.openUrl({
            title: 'File Manager',
            url: '{{ route('elfinder.tinymce5') }}',
            /**
             * On message will be triggered by the child window
             *
             * @param dialogApi
             * @param details
             * @see https://www.tiny.cloud/docs/ui-components/urldialog/#configurationoptions
             */
            onMessage: function (dialogApi, details) {
                if (details.mceAction === 'fileSelected') {
                    const file = details.data.file;

                    // Make file info
                    const info = file.name;

                    // Provide file and text for the link dialog
                    if (meta.filetype === 'file') {
                        callback(file.url, {text: info, title: info});
                    }

                    // Provide image and alt text for the image dialog
                    if (meta.filetype === 'image') {
                        callback(file.url, {alt: info});
                    }

                    // Provide alternative source and posted for the media dialog
                    if (meta.filetype === 'media') {
                        callback(file.url);
                    }

                    dialogApi.close();
                }
            }
        });
    }
</script>

@if(Route::currentRouteName() != 'Article > Manage')

    <style>
        li.select2-selection__choice {
            color: #727272;
        }
        .tox-notification.tox-notification--in.tox-notification--warning {
            display: none;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.uk-select').select2();
        });
    </script>

@endif

{{-- Theme mode switcher --}}
<script>
    function switch_theme(mode) {

        const switches = document.getElementsByClassName('uk-section');

        for (let item of switches) {
            item.classList.remove('uk-light');
            item.classList.remove('uk-background-secondary');
            item.classList.remove('uk-section-secondary');
            item.classList.remove('uk-section-default');
            item.classList.add('uk-background-default');
            item.classList.add('uk-dark');
        }

    }

    // switch_theme('light');
</script>

<script>
    document.getElementsByClassName('tox-notifications-container')[0].style.width = '0px';
    document.getElementsByClassName('tox-notifications-container')[0].style.visibility = 'hidden';
</script>
