<div class="form-group">
    <label for="title">Your Title</label>
    <input type="text" class="form-control" id="title" name="title" value="{{ $post->title ?? null }}">
</div>
<div class="form-group">
    <label for="content">Your Content</label>
    <input type="text" class="form-control" id="content" name="content" value="{{ $post->content ?? null }}">
</div>
<div class="form-group ">
    <label for="picture" >{{ __('Picture') }}</label>
    <div class="col-md-6">
            <div class="input-group mb-3">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="inputGroupFile02" id="picture" name="picture">
                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
              </div>
              <div class="input-group-append">
                <span class="input-group-text">Upload</span>
              </div>
            </div>

    </div>
</div>
{{-- <div class="form-check">
    <input type="checkbox" class="form-check-input" name="active" id="active" value="{{ ($post->active ?? null) ? '0':'1' }}" {{ ($post->active ?? null) ? 'checked':'' }}>
    <label for="active" class="form-check-label">status(acvive/desactive)</label>
</div> --}}

