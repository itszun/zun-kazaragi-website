@extends('admin._template.main')
@push('head')

<!-- Core build with no theme, formatting, non-essential modules -->
<link rel="stylesheet" href="{{ asset('vendor/ckeditor/skins/office2013/editor.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/ckeditor/skins/office2013/dialog.css') }}">
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
@endpush

@push('script')
<script>
    $(document).ready(() => {
        var config = {
            height: "500",
        }
        CKEDITOR.replace('editor', config)
        $('#editor').removeClass('d-none')
    })
</script>
@endpush

@section('content')
<form action="" cemes="form" method="POST" cemes-redirect="{{ url()->previous() }}">
    <div class="row">
        <div class="col-9">
            <div class="bg-white border">
                <div class="row my-3">
                    <div class="col-8">
                        <textarea type="text" id="title" name="title" placeholder="Title" class="form-control article-title"
                        >{{ $article->title }}</textarea>
                    </div>
                    <div class="col-4">
                        <div class="float-right p-3">
                            <a href="{{ route('admin.article.index') }}" class="btn border">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
                <textarea name="body" id="editor" cols="30" rows="1" class="d-none">
                    {{ $article->body }}
                </textarea>
            </div>
        </div>
        <div class="col-3">
            <div class="bg-white">
                TEst
            </div>
        </div>
    </div>

</form>
@endsection
