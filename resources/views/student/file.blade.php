<div class="card">
    <div class="card-body">
        @error('name')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
        </div>
        @enderror
        @foreach($lampiran as $ln)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" onclick="return false;" {{ $ln->status === 'Y' ? 'checked' : '' }}>
            <label class="form-check-label">
                {{$ln->document_name}} {{ empty($ln->updated_at) ? '' : '(Perubahan Terakhir: '.date_format(date_create($ln->updated_at),"d/m/Y H:i:s").')' }}
            </label>
            <label class="form-check-label">
                <button class="btn btn-sm btn-primary" type="button" data-coreui-toggle="modal" data-coreui-target="#upload-file" data-coreui-uploadfile="{{$ln->id}}" data-coreui-uploadfiletitle="{{$ln->document_name}}"><i class="cil-cloud-upload"></i></button>
            </label>
            @if($ln->status === 'Y')
            <label class="form-check-label">
                <button class="btn btn-sm btn-success" type="button" data-coreui-toggle="modal" data-coreui-target="#view-file" data-coreui-file="{{asset('documents/'.$ln->period.'/'.$ln->name)}}" data-coreui-filetitle="{{$ln->document_name}}"><i class="cil-search" style="font-weight:bold"></i></button>
            </label>
            @endif
        </div>
        @endforeach
    </div>
</div>
<div class="modal fade" id="upload-file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('lampiran') }}" method="post" enctype="multipart/form-data" class="needs-validation-file" novalidate>
                @csrf
                    <input type="hidden" name="id" id="upload-file-id">
                    <div class="col mb-3">
                        <input type="file" name="name" class="form-control" required>
                        <div class="invalid-feedback">File Wajib Diisi!</div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="view-file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <embed src="" id="file-name" style="max-width: 100%;">
            </div>
        </div>
    </div>
</div>