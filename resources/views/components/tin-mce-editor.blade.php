@props(['id' => 'editor', 'name' => 'content', 'value' => ''])

<textarea
    id="{{ $id }}"
    name="{{ $name }}"
    class="hidden"
>{{ $value }}</textarea>

@once
    @push('styles')
        <style>
            .tox-statusbar__branding {
                display: none;
            }
        </style>
    @endpush
    
    @push('scripts')
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                initTinyMCE();
            });
            
            function initTinyMCE() {
                tinymce.init({
                    selector: '#{{ $id }}',
                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect typography inlinecss',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                    tinycomments_mode: 'embedded',
                    tinycomments_author: 'ZPlus Editor',
                    promotion: false,
                    branding: false,
                    mergetags_list: [
                        {value: 'First.Name', title: 'First Name'},
                        {value: 'Email', title: 'Email'},
                    ],
                    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See documentation for details")),
                    height: 500,
                    menubar: true,
                    statusbar: true,
                    setup: function(editor) {
                        editor.on('change', function() {
                            tinymce.triggerSave();
                        });
                    },
                    // Cấu hình upload ảnh
                    images_upload_handler: function (blobInfo, progress) {
                        return new Promise((resolve, reject) => {
                            const xhr = new XMLHttpRequest();
                            xhr.withCredentials = false;
                            
                            xhr.open('POST', '{{ route("admin.media.upload") }}');
                            
                            // Lấy CSRF token từ thẻ meta
                            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            xhr.setRequestHeader("X-CSRF-Token", token);
                            
                            xhr.upload.onprogress = function(e) {
                                progress(e.loaded / e.total * 100);
                            };
                            
                            xhr.onload = function() {
                                if (xhr.status === 403) {
                                    reject({message: 'HTTP Error: ' + xhr.status, remove: true});
                                    return;
                                }
                                
                                if (xhr.status < 200 || xhr.status >= 300) {
                                    reject('HTTP Error: ' + xhr.status);
                                    return;
                                }
                                
                                const json = JSON.parse(xhr.responseText);
                                
                                if (!json || typeof json.location !== 'string') {
                                    reject('Invalid JSON: ' + xhr.responseText);
                                    return;
                                }
                                
                                resolve(json.location);
                            };
                            
                            xhr.onerror = function() {
                                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                            };
                            
                            const formData = new FormData();
                            formData.append('file', blobInfo.blob(), blobInfo.filename());
                            
                            xhr.send(formData);
                        });
                    }
                });
            }
        </script>
    @endpush
@endonce