<div class="card">
    <div class="card-header">
        Perubahan Terakhir: {{ empty($dp->updated_at) ? date_format(date_create($dp->created_at),"d/m/Y H:i:s") : date_format(date_create($dp->updated_at),"d/m/Y H:i:s") }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('asalsekolah') }}" class="needs-validation" novalidate>
            @csrf
            <div class="row">
                <div class="col-sm-10 mb-3">
                    <label class="form-label">Nama Sekolah</label>
                    <input type="text" class="form-control" name="School_Name" value="{{$as->school_name}}" readonly>
                </div>
                <div class="col-sm-2 mb-3 align-self-end">
                    <button type="button" class="btn btn-success text-white" data-coreui-toggle="modal" data-coreui-target="#gantismp">Ganti Sekolah</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <label class="form-label">Alamat Sekolah</label>
                    <textarea name="School_Address" rows="3" class="form-control" id="School_Address" readonly>{{$as->school_address}}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 mb-3">
                    <label class="form-label">Provinsi</label>
                    <input type="text" class="form-control" name="School_Province_Desc" id="School_Province_Desc" value="{{$as->school_province}}" readonly>
                </div>
                <div class="col-sm-4 mb-3">
                    <label class="form-label">Kota/Kabupaten</label>
                    <input type="text" class="form-control" name="School_City_Desc" id="School_City_Desc" value="{{$as->school_city}}" readonly>
                </div>
                <div class="col-sm-4 mb-3">
                    <label class="form-label">Kecamatan</label>
                    <input type="text" class="form-control" name="School_Distric_Desc" id="School_Distric_Desc" value="{{$as->school_distric}}" readonly>
                </div>
            </div>
            <div class="alert alert-info" role="alert">
            Jika Nama Sekolah tidak ada atau salah, Silahkan masukkan pada kolom Keterangan meliputi:
                <ul>
                    <li>Nama Sekolah</li>
                    <li>Swasta/Negeri</li>
                    <li>Alamat</li>
                    <li>Kecamatan</li>
                    <li>Kota/Kabupaten</li>
                    <li>Provinsi</li>
                </ul>
            Contoh: SMA Plus PGRI Cibinong, Swasta, Jl. Raya Ciriung, Cibinong, Kab.Bogor, Jawa Barat
            </div>
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="remark" rows="3" class="form-control">{{$as->remark}}</textarea>
                    @error('remark')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Tahun Lulus</label>
                    <input type="number" class="form-control" name="school_year" value="{{$as->school_year}}">
                    @error('school_year')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">NISN</label>
                    <input type="text" class="form-control" name="nisn" value="{{$as->nisn}}" maxlength="20" required>
                    @error('nisn')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">NISN Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Nilai Rata2 NEM</label>
                    <input type="number" class="form-control" name="school_nem_avg" value="{{$as->school_nem_avg}}" step=".01">
                    @error('school_new_avg')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Nilai Rata2 STTB</label>
                    <input type="number" class="form-control" name="school_sttb_avg" value="{{$as->school_sttb_avg}}" step=".01">
                    @error('school_sttb_avg')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 mb-3">
                    <label class="form-label">No. Peserta UN</label>
                    <input type="text" class="form-control" name="exam_un_no" value="{{$as->exam_un_no}}" maxlength="30">
                    @error('exam_un_no')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3">
                    <label class="form-label">No. SKHUN</label>
                    <input type="text" class="form-control" name="skhun_no" value="{{$as->skhun_no}}" maxlength="30">
                    @error('skhun_no')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3">
                    <label class="form-label">No. Ijazah</label>
                    <input type="text" class="form-control" name="certificate_no" value="{{$as->certificate_no}}" maxlength="30">
                    @error('certificate_no')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <input type="submit" class="btn btn-primary" value="Simpan">
        </form>
    </div>
</div>
<div class="modal fade cd-example-modal-lg" id="gantismp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ganti Sekolah</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" name="search-smp" id="search-smp" placeholder="Cari Sekolah ...">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Provinsi</th>
                                <th>Kota/Kab</th>
                                <th>Kecamatan</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-search-smp">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>