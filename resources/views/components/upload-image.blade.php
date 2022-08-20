<div class="form-group image-container">
    <div class="form-group hidden">
        <input type="file" name="image" placeholder="Choose image" class="image" accept="image/*">
    </div>

    <div class="row">
        <div class="col-lg-12 d-flex justify-content-center align-items-center">
            <div class="image-upload">
                <img data-id="{{ isset($object) ? $object->id : '' }}" data-type="{{ $type }}"
                    class="image_preview_container"
                    src="{{ $type == 1 ? asset($object->image ?? 'resources/assets/img/upload-image.png') : asset('resources/assets/img/upload-image.png') }}"
                    alt="preview image">
                <div class="remove-image">
                    <button type="button" class="remove-image-button">
                        <i class="fa fa-times"></i></button>
                </div>

            </div>
        </div>
    </div>
    <script>
        var delete_image = "{{ $deleteImage }}";
    </script>
</div>
