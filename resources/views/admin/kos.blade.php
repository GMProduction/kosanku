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
                   <button type="button" class="btn btn-primary btn-sm" id="addData">Tambah Data
                   </button>
               </div>
            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nama Kos</th>
                    <th>Alamat</th>
                    <th>Mitra</th>
                    <th>Harga / Bulan</th>
                    <th>Action</th>
                </tr>
                </thead>
                @forelse($data as $key => $d)
                    <tr>
                        <td>{{$data->firstItem() + $key}}</td>
                        <td><img src="{{$d->foto}}" onerror="this.src='{{asset('/images/noimage.png')}}'; this.error=null"
                                 style="height: 100px; object-fit: cover"/></td>
                        <td>{{$d->nama}}</td>
                        <td>{{$d->alamat}}</td>
                        <td>{{$d->user->nama}}</td>
                        <td>Rp. {{number_format($d->harga,0)}}</td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm" data-peruntukan="{{$d->peruntukan}}" data-harga="{{$d->harga}}" data-long="{{$d->longtitude}}"
                                    data-lat="{{$d->latitude}}" data-user="{{$d->user_id}}" data-alamat="{{$d->alamat}}" data-keterangan="{{$d->keterangan}}" data-nama="{{$d->nama}}"
                                    data-foto="{{$d->foto ?? asset('/images/noimage.png')}}" data-id="{{$d->id}}" id="editData">Ubah
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapus('{{$d->id}}', '{{$d->nama}}') ">hapus</button>
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
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form onsubmit="return save()" id="form">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama Kos</label>
                                            <input type="text" required class="form-control" id="nama" name="nama">
                                        </div>

                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea class="form-control" id="alamat" rows="3" name="alamat" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <textarea class="form-control" id="keterangan" rows="3" name="keterangan" required></textarea>
                                        </div>


                                        <div class="mt-3 mb-2">
                                            <label for="foto" class="form-label">Foto</label>
                                            <input class="form-control" type="file" id="foto" name="foto">
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="latitude" class="form-label">Latitude</label>
                                            <input type="text" required class="form-control" id="latitude" name="latitude">
                                        </div>

                                        <div class="mb-3">
                                            <label for="longitude" class="form-label">Longitude</label>
                                            <input type="text" required class="form-control" id="longitude" name="longtitude">
                                        </div>

                                        <div class="mb-3">
                                            <label for="peruntukan" class="form-label">Peruntukan</label>
                                            <div class="d-flex">
                                                <select class="form-select" aria-label="Default select example" id="peruntukan" name="peruntukan" required>
                                                    <option selected disabled value="">Pilih Peruntukan</option>
                                                    <option value="Kos Campur">Kos Campur</option>
                                                    <option value="Kos Putra">Kos Putra</option>
                                                    <option value="Kos Putri">Kos Putri</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="harga" class="form-label">Harga /bulan</label>
                                            <input type="text" required class="form-control" id="harga" name="harga">
                                        </div>

                                        <div class="mb-3">
                                            <label for="user_id" class="form-label">Mitra</label>
                                            <div class="d-flex">
                                                <select class="form-select" aria-label="Default select example" id="user_id" name="user_id" required>
                                                    <option selected disabled value="">Pilih Mitra</option>
                                                    @foreach($user as $us)
                                                        <option value="{{$us->id}}">{{$us->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalTrash" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Data Kos Dihapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="overflow-auto">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Foto</th>
                                        <th>Nama Kos</th>
                                        <th>Alamat</th>
                                        <th>Mitra</th>
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
        </div>

    </section>

@endsection

@section('script')
    <script>
        var statusKos;
        $(document).ready(function () {

        })

        $('#modalTrash').on('hidden.bs.modal', function () {
            // do something…
            console.log('close')
            if (statusKos){
                window.location.reload();
            }
        })
        function save() {
            saveData('Simpan data', 'form')
            return false;
        }

        function after() {
            statusKos = 1;
            getTrash();
        }

        $(document).on('click', '#addData, #editData', function () {
            $('#modal #id').val($(this).data('id'))
            $('#modal #nama').val($(this).data('nama'))
            $('#modal #alamat').val($(this).data('alamat'))
            $('#modal #keterangan').val($(this).data('keterangan'))
            $('#modal #latitude').val($(this).data('lat'))
            $('#modal #longitude').val($(this).data('long'))
            $('#modal #peruntukan').val($(this).data('peruntukan'))
            $('#modal #harga').val($(this).data('harga'))
            $('#modal #user_id').val($(this).data('user'))
            $('#modal').modal('show');
        })

        function hapus(id, name) {
            deleteData(name,window.location.pathname+'/delete/'+id)
            return false;
        }

        $(document).on('click', '#trash', function () {
            statusKos = null;
            getTrash()
            $('#modalTrash').modal('show')
        })

        function getTrash() {
            fetch(window.location.pathname+'/trash')
            .then(response => response.json())
            .then((data) => {
                var tb = $('#tbTrash');
                tb.empty();
                if(data.length > 0){
                    $.each(data, function (k, v) {
                        var img = v['foto'] ?? '/images/noimage.png';
                        tb.append('<tr>' +
                            '<td>'+parseInt(k+1)+'</td>' +
                            '<td><img src="'+img+'" height="70"/></td>' +
                            '<td>'+v['nama']+'</td>' +
                            '<td>'+v['alamat']+'</td>' +
                            '<td>'+v['user']['nama']+'</td>' +
                            '<td>'+v['harga']+'</td>' +
                            '<td><a class="btn btn-sm btn-info" data-id="'+v['id']+'" data-nama="'+v['nama']+'" id="restore"><i class=\'bx bx-undo\' style="color: white"></i></a></td>' +
                            '</tr>')
                    })
                }
            })
        }

        $(document).on('click','#restore', function () {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var form_data = {
                '_token': '{{csrf_token()}}'
            }
            saveDataObject('Restore data '+nama+' kos yang terhapus', form_data, window.location.pathname+'/restore/'+id, after)
            return false;
        })
    </script>

@endsection
