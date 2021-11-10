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
                <button type="button ms-auto" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#tambahsiswa">Tambah Data
                </button>
            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nama Kos</th>
                    <th>Alamat</th>
                    <th>Mitra</th>
                    <th>Action</th>
                </tr>
                </thead>
                @forelse($data as $key => $d)
                    <tr>
                        <td>{{$data->firstItem() + $key}}</td>
                       <td> <img src="{{$d->foto}}" onerror="this.src='{{asset('/images/noimage.png')}}'; this.error=null"
                                 style="height: 100px; object-fit: cover"/></td>
                        <td>{{$d->nama}}</td>
                        <td>{{$d->alamat}}</td>
                        <td>{{$d->user->nama}}</td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#tambahsiswa">Ubah
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapus('id', 'nama') ">hapus</button>
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
            <div class="modal fade" id="tambahsiswa" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama Kos</label>
                                            <input type="text" required class="form-control" id="nama">
                                        </div>

                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea class="form-control" id="alamat" rows="3"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <textarea class="form-control" id="alamat" rows="3"></textarea>
                                        </div>


                                        <div class="mt-3 mb-2">
                                            <label for="foto" class="form-label">Foto</label>
                                            <input class="form-control" type="file" id="foto">
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="latitude" class="form-label">Latitude</label>
                                            <input type="text" required class="form-control" id="latitude">
                                        </div>

                                        <div class="mb-3">
                                            <label for="longitude" class="form-label">Longitude</label>
                                            <input type="text" required class="form-control" id="longitude">
                                        </div>

                                        <div class="mb-3">
                                            <label for="kategori" class="form-label">Peruntukan</label>
                                            <div class="d-flex">
                                                <select class="form-select" aria-label="Default select example" name="idguru">
                                                    <option selected>Pilih Peruntukan</option>
                                                    <option value="1">Kos Campur</option>
                                                    <option value="2">Kos Putra</option>
                                                    <option value="3">Kos Putri</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="harga" class="form-label">Harga /bulan</label>
                                            <input type="text" required class="form-control" id="harga">
                                        </div>

                                        <div class="mb-3">
                                            <label for="kategori" class="form-label">Mitra</label>
                                            <div class="d-flex">
                                                <select class="form-select" aria-label="Default select example" name="idguru">
                                                    <option selected>Pilih Mitra</option>
                                                    <option value="1">Asep</option>
                                                    <option value="2">Budi</option>
                                                    <option value="3">Candra</option>
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

        </div>

    </section>

@endsection

@section('script')
    <script>
        $(document).ready(function () {

        })

        function hapus(id, name) {
            swal({
                title: "Menghapus data?",
                text: "Apa kamu yakin, ingin menghapus data ?!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Berhasil Menghapus data!", {
                            icon: "success",
                        });
                    } else {
                        swal("Data belum terhapus");
                    }
                });
        }
    </script>

@endsection
