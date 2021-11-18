@extends('admin.base')

@section('title')
    Data Siswa
@endsection

@section('content')

    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            swal("Berhasil!", "Berhasil Menambah data!", "success");
        </script>
    @endif

    <section class="m-2">


        <div class="table-container">


            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Data User</h5>
                <div>
                    <a class="btn btn-success" id="trash"><i class='bx bx-trash'></i></a>
                    <button type="button ms-auto" class="btn btn-primary btn-sm" id="addData">Tambah Data
                    </button>
                </div>
            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                <th>#</th>
                <th>Avatar</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No Hp</th>
                <th>Role</th>
                <th>Action</th>
                </thead>
                @forelse($data as $key => $d)

                    <tr>
                        <td>{{$data->firstItem() + $key}}</td>
                        <td width="100">
                            <img src="{{$d->avatar}}" onerror="this.src='{{asset('/images/nouser.png')}}'; this.error=null"
                                 style=" height: 100px; object-fit: cover"/>
                        </td>
                        <td>{{$d->nama}}</td>
                        <td>{{$d->alamat}}</td>
                        <td>{{$d->no_hp}}</td>
                        <td>{{$d->roles}}</td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm" data-username="{{$d->username}}" data-no_hp="{{$d->no_hp}}" data-alamat="{{$d->alamat}}" data-nama="{{$d->nama}}"
                                    data-roles="{{$d->roles}}" data-id="{{$d->id}}" id="editData">Ubah
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapus('{{$d->id}}', '{{$d->nama}}') ">Hapus</button>
                            @if($d->roles == 'mitra')
                                <button type="button" class="btn btn-warning btn-sm d-block mt-2" style="color: white" data-nama="{{$d->nama}}" data-id="{{$d->id}}" id="dataKos">Data Kos</button>
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data user</td>
                    </tr>
                @endforelse

            </table>
            <div class="d-flex justify-content-end">
                {{$data->links()}}
            </div>

        </div>


        <div>


            <!-- Modal Tambah-->
            <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form" onsubmit="return save()">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                <div class="mb-3">
                                    <label for="roles" class="form-label">Role</label>
                                    <div class="d-flex">
                                        <select class="form-select" aria-label="Default select example" id="roles" name="roles">
                                            <option selected>Pilih Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="mitra">Mitra</option>
                                            <option value="user">Pelanggan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" required class="form-control" id="nama" name="nama">
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" rows="3" name="alamat"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="nphp" class="form-label">no. Hp</label>
                                    <input type="number" required class="form-control" id="nphp" name="no_hp">
                                </div>


                                <hr>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" required class="form-control" id="username" name="username">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" required class="form-control" id="password" name="password">
                                </div>

                                <div class="mb-3">
                                    <label for="password-confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" required class="form-control" id="password-confirmation" name="password_confirmation">
                                </div>


                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="modalKos" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Data Kos <span id="pemilik"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5>Kos Aktif</h5>
                        <div class="overflow-auto" style="max-height: 50vh">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nama Kos</th>
                                    <th>Alamat</th>
                                    <th>Harga / Bulan</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="tbAktif">

                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <h5 class="my-2">Kos Dihapus</h5>
                        <div class="overflow-auto" style="max-height: 50vh">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nama Kos</th>
                                    <th>Alamat</th>
                                    <th>Harga / Bulan</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="tbTrash">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="modal fade" id="modalUserTrash" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Data User Dihapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="overflow-auto" style="max-height: 50vh">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Avatar</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No Hp</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="tbTrashUser">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>

        var idKos, idUser;
        var statusUser;

        $(document).ready(function () {

        })

        $('#modalUserTrash').on('hidden.bs.modal', function () {
            // do something…
            if (statusUser){
                window.location.reload();
            }
        })

        function save() {
            saveData('Simpan Data', 'form', window.location.pathname + '/register')
            return false;
        }

        function after() {

        }

        $(document).on('click', '#addData, #editData', function () {
            $('#modal #id').val($(this).data('id'));
            $('#modal #nama').val($(this).data('nama'));
            $('#modal #roles').val($(this).data('roles'));
            $('#modal #alamat').val($(this).data('alamat'));
            $('#modal #nphp').val($(this).data('no_hp'));
            $('#modal #username').val($(this).data('username'));
            $('#modal #password').val('');
            $('#modal #password-confirmation').val('');
            if ($(this).data('id')) {
                $('#modal #password').val('**********');
                $('#modal #password-confirmation').val('**********');
            }
            $('#modal').modal('show');
        })

        function hapus(id, name) {
            deleteData(name, window.location.pathname + '/delete/' + id);
            return false;
        }

        $(document).on('click', '#dataKos', function () {
            idUser = $(this).data('id');
            var pemilik = $(this).data('nama');
            $('#modalKos #pemilik').html(pemilik);
            $('#modalKos').modal('show');
            getKos(idUser);
            getTrash(idUser);
        })

        function getKos(id) {
            fetch(window.location.pathname + '/' + id + '/kos')
                .then(response => response.json())
                .then((data) => {
                    var tb = $('#tbAktif');
                    tb.empty();
                    if (data.length > 0) {
                        $.each(data, function (k, v) {
                            var img = v['foto'] ?? '/images/noimage.png';
                            tb.append('<tr>' +
                                '<td>' + parseInt(k + 1) + '</td>' +
                                '<td><img src="' + img + '" height="70"/></td>' +
                                '<td>' + v['nama'] + '</td>' +
                                '<td>' + v['alamat'] + '</td>' +
                                '<td>' + v['harga'] + '</td>' +
                                '<td><a class="btn btn-sm btn-danger" data-id="' + v['id'] + '" data-nama="'+v['nama']+'" id="removeKos"><i class=\'bx bx-trash-alt\' style="color: white"></i></a></td>' +
                                '</tr>')
                        })
                    } else {
                        tb.append('<tr><td colspan="7" class="text-center">Tidak ada data kos dihapus</td></tr>')
                    }
                })
        }

        function getTrash(id) {
            fetch(window.location.pathname + '/' + id + '/trash')
                .then(response => response.json())
                .then((data) => {
                    var tb = $('#tbTrash');
                    tb.empty();
                    if (data.length > 0) {
                        $.each(data, function (k, v) {
                            console.log(v)
                            var img = v['foto'] ?? '/images/noimage.png';
                            tb.append('<tr>' +
                                '<td>' + parseInt(k + 1) + '</td>' +
                                '<td><img src="' + img + '" height="70"/></td>' +
                                '<td>' + v['nama'] + '</td>' +
                                '<td>' + v['alamat'] + '</td>' +
                                '<td>' + v['harga'] + '</td>' +
                                '<td><a class="btn btn-sm btn-info" data-id="' + v['id'] + '" data-nama="'+v['nama']+'" id="restore"><i class=\'bx bx-undo\' style="color: white"></i></a></td>' +
                                '</tr>')
                        })
                    } else {
                        tb.append('<tr><td colspan="7" class="text-center">Tidak ada data kos dihapus</td></tr>')
                    }
                })
        }

        function afterKos(){
            getTrash(idUser);
            getKos(idUser);
        }

        $(document).on('click', '#restore', function () {
            var nama = $(this).data('nama')
            idKos = $(this).data('id')
            var form_data = {
                '_token': '{{csrf_token()}}'
            }
            saveDataObject('Restor data user '+nama,form_data, window.location.pathname+'/restore-kos/'+idKos, afterKos)
            return false;
        })



        $(document).on('click', '#removeKos', function () {
            var nama = $(this).data('nama')
            idKos = $(this).data('id')
            deleteData(nama,window.location.pathname+'/delete-kos/'+idKos, afterKos)
            return false;
        })

        $(document).on('click', '#trash', function () {
            getTrashUser()
            statusUser = null;

            $('#modalUserTrash').modal('show')
        })

        $(document).on('click', '#restoreUser', function () {
            var form_data = {
                '_token': '{{csrf_token()}}'
            }
            var nama = $(this).data('nama');
            var id = $(this).data('id');
            saveDataObject('Restore data ' + nama + ' yang sudah dihapus', form_data, window.location.pathname + '/restore/' + id, afterRestorUser)
            return false;
        })

        function afterRestorUser() {
            statusUser = 1;
            getTrashUser();
        }

        function getTrashUser() {
            fetch(window.location.pathname + '/trash')
                .then(response => response.json())
                .then((data) => {
                    var tb = $('#tbTrashUser');
                    tb.empty();
                    if (data.length > 0) {
                        $.each(data, function (k, v) {
                            var img = v['avatar'] ?? '/images/nouser.png';

                            tb.append('<tr>' +
                                '<td>' + parseInt(k + 1) + '</td>' +
                                '<td><img src="' + img + '" height="70"/></td>' +
                                '<td>' + v['nama'] + '</td>' +
                                '<td>' + v['alamat'] + '</td>' +
                                '<td>' + v['no_hp'] + '</td>' +
                                '<td>' + v['roles'] + '</td>' +
                                '<td><a class="btn btn-sm btn-info" data-id="' + v['id'] + '" data-nama="' + v['nama'] + '" id="restoreUser"><i class=\'bx bx-undo\' style="color: white"></i></a></td>' +
                                '</tr>')
                        })
                    } else {
                        tb.append('<tr><td colspan="7" class="text-center">Tidak ada data user dihapus</td></tr>')
                    }
                })
        }
    </script>

@endsection
