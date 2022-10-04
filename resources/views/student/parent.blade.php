<div class="card">
    <div class="card-body">
        <div class="alert alert-info" role="alert">
            Nama Lengkap mengikuti Akta Lahir
        </div>
        @foreach($orangtua as $ot)
        <div class="card border-info mb-3">
            <div class="card-header">
                {{$ot->family_name}} | Perubahan Terakhir: {{ empty($ot->updated_at) ? date_format(date_create($ot->created_at),"d/m/Y H:i:s") : date_format(date_create($ot->updated_at),"d/m/Y H:i:s") }}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('orangtua') }}" class="needs-validation-{{$ot->id}}" novalidate>
                @csrf
                    <input type="hidden" name="family_id" value="{{$ot->id}}">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name_'.$ot->id) is-invalid @enderror" name="name_{{$ot->id}}" value="{{$ot->name}}">
                            @error('name_'.$ot->id)
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" class="form-control @error('id_card_'.$ot->id) is-invalid @enderror" name="id_card_{{$ot->id}}" value="{{$ot->id_card}}" maxlength="100" {{ $ot->job === $dead->id_job ? 'disabled' : '' }}>
                            @error('id_card_'.$ot->id)
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <label class="form-label">Tempat & Tanggal Lahir</label>
                            <input type="text" class="form-control @error('place_'.$ot->id) is-invalid @enderror" name="place_{{$ot->id}}" placeholder="Tempat Lahir" value="{{$ot->place}}" maxlength="150">
                            @error('place_'.$ot->id)
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-2 mb-3 align-self-end">
                            <div class="input-group">
                                @php
                                $Birthdayx_o = date_create($ot->birthday);
                                $Birthday_o = date_format($Birthdayx_o,"Y-m-d");
                                @endphp
                                <input type='text' class="form-control @error('birthday_'.$ot->id) is-invalid @enderror" name="birthday_{{$ot->id}}" id="Birthday_Orangtua_{{$ot->id}}" placeholder="yyyy-mm-dd" value="{{$Birthday_o}}"/>
                                <span class="input-group-text">
                                    <i class="icon cil-calendar"></i>
                                </span>
                                @error('birthday_'.$ot->id)
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Agama</label>
                            <select name="religion_{{$ot->id}}" class="form-select @error('religion_'.$ot->id) is-invalid @enderror">
                                <option value="">--pilih--</option>
                                @foreach($religion as $r)
                                    <option value="{{$r->id}}" {{ $ot->religion === $r->id ? "selected" : "" }}>{{$r->name}}</option>
                                @endforeach
                            </select>
                            @error('religion_'.$ot->id)
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Pendidikan</label>
                            <select name="education_{{$ot->id}}" class="form-select @error('education_'.$ot->id) is-invalid @enderror">
                                <option value="">--pilih--</option>
                                @foreach($education as $e)
                                    <option value="{{$e->id}}" {{ $ot->education === $e->id ? 'selected' : '' }}>{{$e->name}}</option>
                                @endforeach
                            </select>
                            @error('education_'.$ot->id)
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <select name="job_{{$ot->id}}" class="form-select @error('job_'.$ot->id) is-invalid @enderror">
                                <option value="">--pilih--</option>
                                @foreach($job as $j)
                                    <option value="{{$j->id}}" {{ $ot->job === $j->id ? 'selected' : '' }}>{{$j->name}}</option>
                                @endforeach
                            </select>
                            @error('job_'.$ot->id)
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Penghasilan /Bulan</label>
                            <select name="income_{{$ot->id}}" class="form-select @error('income_'.$ot->id) is-invalid @enderror" {{ $ot->job === $dead->id_job ? 'disabled' : '' }}>
                                <option value="">--pilih--</option>
                                @foreach($income as $i)
                                    <option value="{{$i->id}}" {{ $ot->income === $i->id ? 'selected' : '' }}>{{$i->name}}</option>
                                @endforeach
                            </select>
                            @error('income_'.$ot->id)
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="remark_{{$ot->id}}" rows="3" class="form-control @error('remark_'.$ot->id) is-invalid @enderror">{{$ot->remark}}</textarea>
                            @error('remark_'.$ot->id)
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>