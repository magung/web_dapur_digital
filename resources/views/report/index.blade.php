<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Laporan</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="display-4">
            Laporan
        </h1>
        <a href="/" class="btn btn-success" >Home</a>

    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">

                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <h3>Laporan Transaksi</h3>

                        <table class="table table-bordered mt-1">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Pelanggan</th>
                                    <th scope="col">Produk</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ $transaction->created_at }}</td>
                                    <td>{{ $transaction->user_id == 0 ? 'Umum' : $transaction->name }} <br>{{ $transaction->email }} </td>
                                    <td>
                                        
                                        @forelse ($transaction->products as $product)
                                        {{$product->product_name}} {{ isset($product->panjang) ? $product->panjang . " x " . $product->lebar : '' }}  {{$product->satuan}} <br>
                                        @empty
                                        Data tidak tersedia
                                        @endforelse
                                        
                                    </td>
                                    <td>{{ $transaction->final_price }}</td>
                                    <td>{{ $transaction->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center text-mute" colspan="4">Data tidak tersedia</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">

                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <h3>Laporan Stok Produk</h3>
                        <table class="table table-bordered mt-1">
                            <thead>
                                <tr>
                                    <th scope="col">Produk</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Toko</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                <tr>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->category_name }}</td>
                                    <td>{{ $product->branch_name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->satuan }}</td>
                                    <td>{{ $product->stock }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center text-mute" colspan="4">Data tidak tersedia</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>