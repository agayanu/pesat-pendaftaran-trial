<div class="card">
    <div class="card-header">
        <button class="btn btn-sm btn-primary" type="button" data-coreui-toggle="modal" data-coreui-target="#tambah-prestasi"><i class="cil-plus" style="font-weight:bold"></i> Tambah</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kelompok/Bidang</th>
                        <th>Perlombaan/Kejuaraan</th>
                        <th>Tahun</th>
                        <th>Tgl Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($prestasi as $psi)
                <tr>
                    <td>{{$psi->group_name}}</td>
                    <td>{{$psi->name}}</td>
                    <td>{{$psi->year}}</td>
                    <td>{{ empty($psi->updated_at) ? date_format(date_create($psi->created_at),"d/m/Y H:i:s") : date_format(date_create($psi->updated_at),"d/m/Y H:i:s") }}</td>
                    <td>
                        <button class="btn btn-sm btn-info text-white" type="button" data-coreui-toggle="modal" data-coreui-target="#lihat-prestasi" data-coreui-group="{{$psi->group_name}}" data-coreui-name="{{$psi->name}}" data-coreui-rank="{{$psi->rank_name}}" data-coreui-level="{{$psi->level_name}}" data-coreui-year="{{$psi->year}}" data-coreui-remark="{{$psi->remark}}"><i class="cil-magnifying-glass" style="font-weight:bold"></i></button>
                        <button class="btn btn-sm btn-success text-white" type="button" data-coreui-toggle="modal" data-coreui-target="#edit-prestasi" data-coreui-id="{{$psi->id}}" data-coreui-group="{{$psi->group}}" data-coreui-name="{{$psi->name}}" data-coreui-rank="{{$psi->rank}}" data-coreui-level="{{$psi->level}}" data-coreui-year="{{$psi->year}}" data-coreui-remark="{{$psi->remark}}"><i class="cil-pen" style="font-weight:bold"></i></button>
                        <button class="btn btn-sm btn-danger text-white" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus-prestasi" data-coreui-name="{{$psi->name}}" data-coreui-url="{{url('prestasi/'.$psi->id)}}"><i class="cil-trash" style="font-weight:bold"></i></button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="tambah-prestasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('prestasi') }}" method="post" class="needs-validation" novalidate>
                @csrf
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Kelompok/Bidang <div class="required">*</div></label>
                            <select name="group" class="form-select" required>
                                <option value="">--pilih--</option>
                                @foreach ( $achievementGroup as $acg )
                                    <option value="{{$acg->id}}">{{$acg->name}}</option>   
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Kelompok/Bidang Wajib Diisi!</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Perlombaan/Kejuaraan <div class="required">*</div></label>
                            <input type="text" class="form-control" name="name" required>
                            <div class="invalid-feedback">Perlombaan/Kejuaraan Wajib Diisi!</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Peringkat <div class="required">*</div></label>
                            <select name="rank" class="form-select" required>
                                <option value="">--pilih--</option>
                                @foreach ( $achievementRank as $acr )
                                    <option value="{{$acr->id}}">{{$acr->name}}</option>   
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Peringkat Wajib Diisi!</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Tingkat <div class="required">*</div></label>
                            <select name="level" class="form-select" required>
                                <option value="">--pilih--</option>
                                @foreach ( $achievementLevel as $acl )
                                    <option value="{{$acl->id}}">{{$acl->name}}</option>   
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Tingkat Wajib Diisi!</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Tahun <div class="required">*</div></label>
                            <input type="number" class="form-control" name="year" min="2000" required>
                            <div class="invalid-feedback">Tahun Wajib Diisi!</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="remark" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="lihat-prestasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lihat</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Kelompok/Bidang</label>
                        <input type="text" class="form-control" id="group" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Perlombaan/Kejuaraan</label>
                        <input type="text" class="form-control" id="name" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Peringkat</label>
                        <input type="text" class="form-control" id="rank" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Tingkat</label>
                        <input type="text" class="form-control" id="level" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="text" class="form-control" id="year" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea id="remark" rows="3" class="form-control" readonly></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit-prestasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('prestasi-perbarui') }}" method="post" class="needs-validation" novalidate>
                @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Kelompok/Bidang <div class="required">*</div></label>
                            <select name="group" id="group" class="form-select" required>
                                <option value="">--pilih--</option>
                                @foreach ( $achievementGroup as $acg )
                                    <option value="{{$acg->id}}">{{$acg->name}}</option>   
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Kelompok/Bidang Wajib Diisi!</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Perlombaan/Kejuaraan <div class="required">*</div></label>
                            <input type="text" class="form-control" name="name" id="name" required>
                            <div class="invalid-feedback">Perlombaan/Kejuaraan Wajib Diisi!</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Peringkat <div class="required">*</div></label>
                            <select name="rank" id="rank" class="form-select" required>
                                <option value="">--pilih--</option>
                                @foreach ( $achievementRank as $acr )
                                    <option value="{{$acr->id}}">{{$acr->name}}</option>   
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Peringkat Wajib Diisi!</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Tingkat <div class="required">*</div></label>
                            <select name="level" id="level" class="form-select" required>
                                <option value="">--pilih--</option>
                                @foreach ( $achievementLevel as $acl )
                                    <option value="{{$acl->id}}">{{$acl->name}}</option>   
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Tingkat Wajib Diisi!</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Tahun <div class="required">*</div></label>
                            <input type="number" class="form-control" name="year" id="year" min="2000" required>
                            <div class="invalid-feedback">Tahun Wajib Diisi!</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="remark" id="remark" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hapus-prestasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="hapus-form">
                @csrf
                @method('delete')
                    <div class="row">
                        <div class="col mb-3">
                            <span id="pesan"></span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger">Ya</button>
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Tidak</button>
                </form>
            </div>
        </div>
    </div>
</div>