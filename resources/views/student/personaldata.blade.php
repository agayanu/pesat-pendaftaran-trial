<div class="card">
    <div class="card-header">
        Perubahan Terakhir: {{ empty($dp->updated_at) ? date_format(date_create($dp->created_at),"d/m/Y H:i:s") : date_format(date_create($dp->updated_at),"d/m/Y H:i:s") }}
    </div>
    <div class="card-body">
        <div class="alert alert-info" role="alert">
            Nama Lengkap, Tempat Lahir, Tanggal Lahir mengikuti Akta Lahir
        </div>
        <form action="{{ route('datapribadi') }}" method="post" class="needs-validation" novalidate>
            @csrf
            <div class="row">
                <div class="col-sm-8 mb-3">
                    <label class="form-label">Nama Lengkap <div class="required">*</div></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$dp->name}}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Nama Lengkap Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label class="form-label">Nama Panggilan</label>
                    <input type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname" value="{{$dp->nickname}}" maxlength="50">
                    @error('nickname')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Tempat & Tanggal Lahir <div class="required">*</div></label>
                    <input type="text" class="form-control @error('place') is-invalid @enderror" name="place" placeholder="Tempat Lahir" value="{{$dp->place}}" maxlength="150" required>
                    @error('place')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Tempat Lahir Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-2 mb-3 align-self-end">
                    <div class="input-group">
                        @php
                        $Birthdayx = date_create($dp->birthday);
                        $Birthday = date_format($Birthdayx,"Y-m-d");
                        @endphp
                        <input type='text' class="form-control @error('birthday') is-invalid @enderror" placeholder="yyyy-mm-dd" name="birthday" id="Birthday" value="{{$Birthday}}" required/>
                        <span class="input-group-text">
                            <i class="icon cil-calendar"></i>
                        </span>
                        @error('birthday')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @else
                        <div class="invalid-feedback">Tanggal Lahir Wajib Diisi!</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 mb-3">
                    <label class="form-label">No. Akta Lahir</label>
                    <input type="text" class="form-control @error('birthday_id') is-invalid @enderror" name="birthday_id" value="{{$dp->birthday_id}}" maxlength="50">
                    @error('birthday_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3">
                    <label class="form-label">No. KK</label>
                    <input type="text" class="form-control @error('family_id') is-invalid @enderror" name="family_id" value="{{$dp->family_id}}" maxlength="50">
                    @error('family_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3">
                    <label class="form-label">No. NIK</label>
                    <input type="text" class="form-control @error('id_card') is-invalid @enderror" name="id_card" value="{{$dp->id_card}}" maxlength="50">
                    @error('id_card')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2 mb-3">
                    <label class="form-label">Anak Ke-</label>
                    <input type="number" class="form-control @error('child_no') is-invalid @enderror" name="child_no" value="{{$dp->child_no}}">
                    @error('child_no')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-2 mb-3">
                    <label class="form-label">Jumlah Saudara</label>
                    <input type="number" class="form-control @error('child_qty') is-invalid @enderror" name="child_qty" value="{{$dp->child_qty}}">
                    @error('child_qty')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-2 mb-3">
                    <label class="form-label">Tinggi Badan (cm)</label>
                    <input type="number" class="form-control @error('height') is-invalid @enderror" name="height" value="{{$dp->height}}">
                    @error('height')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-2 mb-3">
                    <label class="form-label">Berat Badan (kg)</label>
                    <input type="number" class="form-control @error('weight') is-invalid @enderror" name="weight" value="{{$dp->weight}}">
                    @error('weight')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-2 mb-3">
                    <label class="form-label">Lingkar Kepala (cm)</label>
                    <input type="number" class="form-control @error('head_size') is-invalid @enderror" name="head_size" value="{{$dp->head_size}}">
                    @error('head_size')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 mb-3">
                    <label class="form-label">Jarak Tempat Tinggal (km)</label>
                    <input type="number" class="form-control @error('distance') is-invalid @enderror" name="distance" value="{{$dp->distance}}" max="100" step=".01">
                    @error('distance')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3">
                    <label class="form-label">Waktu Tempuh (jam)</label>
                    <input type="number" class="form-control @error('time_hh') is-invalid @enderror" name="time_hh" value="{{$dp->time_hh}}" max="24">
                    @error('time_hh')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3">
                    <label class="form-label">Waktu Tempuh (menit)</label>
                    <input type="number" class="form-control @error('time_mm') is-invalid @enderror" name="time_mm" value="{{$dp->time_mm}}" max="60">
                    @error('time_mm')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2 mb-3">
                    <label class="form-label">Agama <div class="required">*</div></label>
                    <select name="religion" class="form-select @error('religion') is-invalid @enderror" required>
                        <option value="">--pilih--</option>
                        @foreach($religion as $r)
                            <option value="{{$r->id}}" {{ $dp->religion === $r->id ? "selected" : "" }}>{{$r->name}}</option>
                        @endforeach
                    </select>
                    @error('religion')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Agama Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-2 mb-3">
                    <label class="form-label">Jenis Kelamin <div class="required">*</div></label>
                    <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                        <option value="">--pilih--</option>
                        @foreach($gender as $g)
                            <option value="{{$g->id}}" {{ $dp->gender === $g->id ? "selected" : "" }}>{{$g->name}}</option>
                        @endforeach
                    </select>
                    @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Jenis Kelamin Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-2 mb-3">
                    <label class="form-label">Kewarganegaraan</label>
                    <select name="citizen" class="form-select @error('citizen') is-invalid @enderror">
                        <option value="">--pilih--</option>
                        @foreach($citizen as $c)
                            <option value="{{$c->id}}" {{ $dp->citizen === $c->id ? "selected" : "" }}>{{$c->name}}</option>
                        @endforeach
                    </select>
                    @error('citizen')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-2 mb-3">
                    <label class="form-label">Golongan Darah</label>
                    <select name="blood" class="form-select @error('blood') is-invalid @enderror">
                        <option value="">--pilih--</option>
                        @foreach($blood as $b)
                            <option value="{{$b->id}}" {{ $dp->blood === $b->id ? "selected" : "" }}>{{$b->name}}</option>
                        @endforeach
                    </select>
                    @error('blood')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-2 mb-3">
                    <label class="form-label">Transportasi</label>
                    <select name="transport" class="form-select @error('transport') is-invalid @enderror">
                        <option value="">--pilih--</option>
                        @foreach($transport as $t)
                            <option value="{{$t->id}}" {{ $dp->transport == $t->id ? 'selected' : '' }}>{{$t->name}}</option>
                        @endforeach
                    </select>
                    @error('transport')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-2 mb-3">
                    <label class="form-label">Kacamata</label>
                    <select name="glass" class="form-select @error('glass') is-invalid @enderror">
                        <option value="" selected>--pilih--</option>
                        <option value="Y" {{ $dp->glass == 'Y' ? 'selected' : '' }}>Ya</option>
                        <option value="N" {{ $dp->glass == 'N' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('glass')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>