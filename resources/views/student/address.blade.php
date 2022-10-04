<div class="card">
    <div class="card-header">
        Perubahan Terakhir: {{ empty($dp->updated_at) ? date_format(date_create($dp->created_at),"d/m/Y H:i:s") : date_format(date_create($dp->updated_at),"d/m/Y H:i:s") }}
    </div>
    <div class="card-body">
        <div class="alert alert-info" role="alert">
            No. HP Ayah adalah nomor Whatsapp yang terdaftar di Sistem Sekolah
        </div>
        <form action="{{ route('alamat') }}" method="post" class="needs-validation" novalidate>
            @csrf
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Alamat Tinggal</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3 mb-3">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="stay_province_desc" value="{{$al->stay_province_desc}}" class="form-control" readonly>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label class="form-label">Kota/Kabupaten</label>
                            <input type="text" name="stay_city_desc" value="{{$al->stay_city_desc}}" class="form-control" readonly>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" name="stay_distric_desc" value="{{$al->stay_distric_desc}}" class="form-control" readonly>
                        </div>
                        <div class="col-sm-3 mb-3 align-self-end">
                            <button type="button" class="btn btn-success text-white" data-coreui-toggle="modal" data-coreui-target="#gantikec-tinggal">
                                Ganti Kecamatan
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <label class="form-label">Kelurahan</label>
                            <input type="text" class="form-control @error('stay_village') is-invalid @enderror" name="stay_village" value="{{$al->stay_village}}">
                            @error('stay_village')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-2 mb-3">
                            <label class="form-label">RT</label>
                            <input type="number" class="form-control @error('stay_rt') is-invalid @enderror" name="stay_rt" value="{{$al->stay_rt}}" maxlength="10">
                            @error('stay_rt')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-2 mb-3">
                            <label class="form-label">RW</label>
                            <input type="number" class="form-control @error('stay_rw') is-invalid @enderror" name="stay_rw" value="{{$al->stay_rw}}" maxlength="10">
                            @error('stay_rw')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-2 mb-3">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" class="form-control @error('stay_postal') is-invalid @enderror" name="stay_postal" value="{{$al->stay_postal}}" maxlength="5">
                            @error('stay_postal')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="stay_address" rows="3" class="form-control" required>{{$al->stay_address}}</textarea>
                            @error('stay_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @else
                            <div class="invalid-feedback">Alamat (Alamat Tinggal) Wajib Diisi!</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Garis Lintang</label>
                            <input type="text" class="form-control" name="stay_latitude" value="{{$al->stay_latitude}}">
                            @error('stay_latitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Garis Bujur</label>
                            <input type="text" class="form-control" name="stay_longitude" value="{{$al->stay_longitude}}">
                            @error('stay_longitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Alamat Rumah</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3 mb-3">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="home_province_desc" value="{{$al->home_province_desc}}" class="form-control" readonly>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label class="form-label">Kota/Kabupaten</label>
                            <input type="text" name="home_city_desc" value="{{$al->home_city_desc}}" class="form-control" readonly>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" name="home_distric_desc" value="{{$al->home_distric_desc}}" class="form-control" readonly>
                        </div>
                        <div class="col-sm-3 mb-3 align-self-end">
                            <button type="button" class="btn btn-success text-white" data-coreui-toggle="modal" data-coreui-target="#gantikec-rumah">
                                Ganti Kecamatan
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <label class="form-label">Kelurahan</label>
                            <input type="text" class="form-control @error('home_village') is-invalid @enderror" name="home_village" value="{{$al->home_village}}">
                            @error('home_village')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-2 mb-3">
                            <label class="form-label">RT</label>
                            <input type="number" class="form-control @error('home_rt') is-invalid @enderror" name="home_rt" value="{{$al->home_rt}}" maxlength="10">
                            @error('home_rt')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-2 mb-3">
                            <label class="form-label">RW</label>
                            <input type="number" class="form-control @error('home_rw') is-invalid @enderror" name="home_rw" value="{{$al->home_rw}}" maxlength="10">
                            @error('home_rw')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-2 mb-3">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" class="form-control @error('home_postal') is-invalid @enderror" name="home_postal" value="{{$al->home_postal}}" maxlength="5">
                            @error('home_postal')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="home_address" rows="3" class="form-control">{{$al->home_address}}</textarea>
                            @error('home_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Garis Lintang</label>
                            <input type="text" class="form-control" name="home_latitude" value="{{$al->home_latitude}}">
                            @error('home_latitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Garis Bujur</label>
                            <input type="text" class="form-control" name="home_longitude" value="{{$al->home_longitude}}">
                            @error('home_longitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 mb-3">
                    <label class="form-label">Jenis Tinggal</label>
                    <select name="stay" class="form-select @error('stay') is-invalid @enderror">
                        <option value="">--pilih--</option>
                        @foreach($stay as $s)
                            <option value="{{$s->id}}" {{ $al->stay === $s->id ? "selected" : "" }}>{{$s->name}}</option>
                        @endforeach
                    </select>
                    @error('stay')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 mb-3">
                    <label class="form-label">No. HP Siswa</label>
                    <input type="text" class="form-control" name="hp_student" value="{{$al->hp_student}}" maxlength="20" required>
                    @error('hp_student')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">No. HP Siswa Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3">
                    <label class="form-label">No. HP Ayah</label>
                    <input type="text" class="form-control" name="hp_parent" value="{{$al->hp_parent}}" maxlength="20" required>
                    @error('hp_parent')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">No. HP Ayah Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3">
                    <label class="form-label">No. HP Ibu</label>
                    <input type="text" class="form-control" name="hp_parent2" value="{{$al->hp_parent2}}" maxlength="20">
                    @error('hp_parent2')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 mb-3">
                    <label class="form-label">Email Siswa</label>
                    <input type="email" class="form-control" name="email_student" value="{{$al->email_student}}" readonly>
                </div>
                <div class="col-sm-4 mb-3">
                    <label class="form-label">Email Ayah</label>
                    <input type="email" class="form-control" name="email_parent" value="{{$al->email_parent}}">
                    @error('email_parent')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3">
                    <label class="form-label">Email Ibu</label>
                    <input type="email" class="form-control" name="email_parent2" value="{{$al->email_parent2}}">
                    @error('email_parent2')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
<div class="modal fade" id="gantikec-tinggal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ganti Kecamatan (Alamat Tinggal)</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" name="search-tinggal" id="search-tinggal" placeholder="Cari Kecamatan ...">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Provinsi</th>
                            <th>Kota/Kab</th>
                            <th>Kecamatan</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-search-tinggal">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="gantikec-rumah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ganti Kecamatan (Alamat Rumah)</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" name="search-rumah" id="search-rumah" placeholder="Cari Kecamatan ...">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Provinsi</th>
                            <th>Kota/Kab</th>
                            <th>Kecamatan</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-search-rumah">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>