@extends('admin.app')

@section('content')
<style>
/* (styles unchanged) */
h3 { margin-top: 2rem; margin-bottom: 1rem; color: var(--accent-color); font-weight: 600; }
.card-section { padding: 1.5rem; border-radius: 10px; border: 1px solid var(--card-border); margin-bottom: 2rem; background-color: #fff; }
#slider-wrapper { display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 0.5rem; }
.slider-preview { width: 150px; height: 80px; position: relative; border-radius: 8px; overflow: hidden; border: 1px solid var(--input-border); background: var(--input-bg); display: flex; align-items: center; justify-content: center; flex-direction: column; }
.slider-preview img { width: 100%; height: 100%; object-fit: cover; }
.action-buttons { position: absolute; bottom: 5px; display: flex; gap: 5px; }
.slider-preview button { background: black; color: #fff; border: none; border-radius: 4px; padding: 3px 8px; cursor: pointer; font-size: 12px; }
.btn-remove { background: red !important; }
.btn-save { padding: 0.6rem 1.5rem; border-radius: 6px; cursor: pointer; color: #fff; border: none; background-color: black; }
.btn-save:hover { background-color: #4f46e5; }
.btn-add { background-color: #4f46e5 !important; color: #fff; padding: .5rem 1rem; border-radius: 6px; border: none; cursor: pointer; }
</style>

<div class="container-fluid">
    @if(session('success'))
        <div style="padding:10px; background:#d1fae5; border:1px solid #10b981; margin-bottom:1rem;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('platform.update.shop') }}" method="POST" enctype="multipart/form-data" id="slider-form">
        @csrf

        <div class="card-section">
            <h3>Slider Images (Max 10)</h3>

            @php
                // decode, remove empty/null, reindex so indexes are contiguous from 0
                $existingImages = $settings && $settings->shop_images ? json_decode($settings->shop_images, true) : [];
                $existingImages = is_array($existingImages) ? array_values(array_filter($existingImages, function($v) {
                    return !is_null($v) && $v !== '' && trim($v) !== '';
                })) : [];
            @endphp

            <div id="slider-wrapper">
                @foreach($existingImages as $index => $image)
                    <div class="slider-preview" data-index="{{ $index }}">
                        <img src="{{ asset($image) }}" alt="slider">
                        {{-- keep an existing hidden field so backend can know this was an existing image if you need it --}}
                        <input type="hidden" name="existing_slider_images[{{ $index }}]" value="{{ $image }}">
                        <div class="action-buttons">
                            <button type="button" class="replace-btn" data-index="{{ $index }}">Replace</button>
                            <button type="button" class="btn-remove remove-btn" data-index="{{ $index }}">Remove</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" id="add-btn" class="btn-add mt-3">Add Image</button>
        </div>

        <button class="btn-save" type="submit">Save Settings</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sliderWrapper = document.getElementById('slider-wrapper');
    const addButton = document.getElementById('add-btn');
    const maxSlots = 10;
    const form = document.getElementById('slider-form');

    function getCurrentCount() {
        return sliderWrapper.querySelectorAll('.slider-preview').length;
    }

    // create a preview DIV for a selected file
    function createPreview(file, index) {
        const previewDiv = document.createElement('div');
        previewDiv.classList.add('slider-preview');
        previewDiv.dataset.index = index;

        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        previewDiv.appendChild(img);

        // create a hidden file input so it will be submitted with the form
        const input = document.createElement('input');
        input.type = 'file';
        input.name = `slider_images[${index}]`;
        input.style.display = 'none';

        // set the FileList via DataTransfer
        try {
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
        } catch (e) {
            // some older browsers may not support DataTransfer; fallback won't attach file but preview still shows
            console.warn('DataTransfer not supported:', e);
        }

        previewDiv.appendChild(input);

        // actions
        const actions = document.createElement('div');
        actions.classList.add('action-buttons');

        const replaceBtn = document.createElement('button');
        replaceBtn.textContent = 'Replace';
        replaceBtn.type = 'button';
        replaceBtn.classList.add('replace-btn');
        replaceBtn.dataset.index = index;
        actions.appendChild(replaceBtn);

        const removeBtn = document.createElement('button');
        removeBtn.textContent = 'Remove';
        removeBtn.type = 'button';
        removeBtn.classList.add('btn-remove', 'remove-btn');
        removeBtn.dataset.index = index;
        actions.appendChild(removeBtn);

        previewDiv.appendChild(actions);
        sliderWrapper.appendChild(previewDiv);

        // events
        replaceBtn.addEventListener('click', () => openTempFilePicker(index, true));
        removeBtn.addEventListener('click', () => removeSlot(index));
    }

    // open a temporary file input to pick file; if isReplace true, it will replace existing index
    function openTempFilePicker(index = null, isReplace = false) {
        const tempInput = document.createElement('input');
        tempInput.type = 'file';
        tempInput.accept = 'image/*';
        tempInput.style.display = 'none';

        tempInput.addEventListener('change', function () {
            if (!this.files || !this.files[0]) {
                // cleanup and exit
                tempInput.remove();
                return;
            }
            const file = this.files[0];

            if (isReplace && index !== null) {
                replaceImage(file, index);
            } else {
                // new image: use current count as new index
                const newIndex = getCurrentCount();
                createPreview(file, newIndex);
                toggleAddButton();
            }

            // cleanup temporary input after used
            tempInput.remove();
        });

        document.body.appendChild(tempInput);
        tempInput.click();
        // DO NOT remove immediately — we remove inside change handler
    }

    function replaceImage(file, index) {
        const previewDiv = sliderWrapper.querySelector(`.slider-preview[data-index="${index}"]`);
        if (!previewDiv) {
            // if preview doesn't exist (edge case), create a new preview
            createPreview(file, index);
            toggleAddButton();
            return;
        }

        // update image preview
        const img = previewDiv.querySelector('img');
        if (img) img.src = URL.createObjectURL(file);

        // remove any existing hidden existing_slider_images input (so backend knows it's replaced)
        const hiddenExisting = previewDiv.querySelector('input[name^="existing_slider_images"]');
        if (hiddenExisting) hiddenExisting.remove();

        // update or create file input to hold the new file for submission
        let fileInput = previewDiv.querySelector('input[type="file"]');
        if (!fileInput) {
            fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.name = `slider_images[${index}]`;
            fileInput.style.display = 'none';
            previewDiv.appendChild(fileInput);
        }

        try {
            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;
        } catch (e) {
            console.warn('DataTransfer not supported:', e);
        }
    }

    function removeSlot(index) {
        const previewDiv = sliderWrapper.querySelector(`.slider-preview[data-index="${index}"]`);
        if (previewDiv) previewDiv.remove();
        // also remove any leftover hidden inputs with matching names
        // renumber remaining previews so indexes remain contiguous
        renumberSlots();
        toggleAddButton();
    }

    function renumberSlots() {
        const previews = sliderWrapper.querySelectorAll('.slider-preview');
        previews.forEach((preview, newIndex) => {
            preview.dataset.index = newIndex;
            // update file input name if present
            const fileInput = preview.querySelector('input[type="file"]');
            if (fileInput) fileInput.name = `slider_images[${newIndex}]`;
            // update hidden existing input name if present
            const hiddenExisting = preview.querySelector('input[name^="existing_slider_images"]');
            if (hiddenExisting) hiddenExisting.name = `existing_slider_images[${newIndex}]`;
            // update action buttons data-index
            const replaceBtn = preview.querySelector('.replace-btn');
            if (replaceBtn) replaceBtn.dataset.index = newIndex;
            const removeBtn = preview.querySelector('.remove-btn');
            if (removeBtn) removeBtn.dataset.index = newIndex;
        });
    }

    function toggleAddButton() {
        addButton.style.display = getCurrentCount() >= maxSlots ? 'none' : 'inline-block';
    }

    // click handler for main Add button
    addButton.addEventListener('click', () => {
        if (getCurrentCount() < maxSlots) {
            openTempFilePicker(null, false);
        }
    });

    // Delegate replace/remove for server-rendered existing previews (in case they exist on load)
    sliderWrapper.addEventListener('click', function (e) {
        const target = e.target;
        if (target.classList.contains('replace-btn')) {
            const idx = parseInt(target.dataset.index, 10);
            openTempFilePicker(idx, true);
        } else if (target.classList.contains('remove-btn')) {
            const idx = parseInt(target.dataset.index, 10);
            removeSlot(idx);
        }
    });

    // initial UI fix: remove any blank previews (in case Blade rendered any empty ones)
    (function cleanupInitial() {
        // remove .slider-preview blocks that have no <img> or the src is empty/null
        const previews = sliderWrapper.querySelectorAll('.slider-preview');
        previews.forEach(preview => {
            const img = preview.querySelector('img');
            if (!img || !img.src || img.src.trim() === '') {
                preview.remove();
            }
        });
        // reindex after cleanup
        renumberSlots();
        toggleAddButton();
    })();

});
</script>
@endsection
