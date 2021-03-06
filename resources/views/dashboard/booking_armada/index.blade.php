@extends('layouts.dashboard')

@section('upper_links')
    @include('partials.datatables_upper_links')
@endsection

@section('content')

@if(session()->has('success_create'))
    <div class="alert alert-success mt-3" role="alert">{{ session('success_create') }}</div>
@elseif(session()->has('success_remove'))
    <div class="alert alert-success mt-3" role="alert">{{ session('success_remove') }}</div>
@elseif(session()->has('success_edit'))
    <div class="alert alert-success mt-3" role="alert">{{ session('success_edit') }}</div>

@elseif(session()->has('fail_remove'))
    <div class="alert alert-danger mt-3" role="alert">{{ session('fail_remove') }}</div>
@elseif(session()->has('fail_edit'))
    <div class="alert alert-danger mt-3" role="alert">{{ session('fail_edit') }}</div>
@endif


<!-- Table  -->
<div>
    <!-- Typography -->
    <h2 class="mt-3"><center>Data Booking Armada Rental Mobil<center></h2>
    <figure class="text-center"> 
        <a href="{{ route('booking_armada.create') }}" type="button" class="btn btn-secondary mt-4 shadow-lg">
            Tambahkan Data Booking Armada
        </a>
        @if($filter)
            <div class="">
                <a href="{{ route('booking_armada.index') }}" type="button" class="btn btn-info mt-4 shadow-lg">
                    Unfilter
                </a>
            </div>
        @else
            <form action="{{ route('booking_armada.index') }}" method="get">
                <input hidden type="number" value="1" name="telat">
                <button type="submit" class="btn btn-info mt-4 shadow-lg">
                    Filter telat
                </button>
            </form>
        @endif

        <div class="container table-responsive mt-4">
            <table id="dt" class="table table-hover table-striped pt-2 mb-2 order-column ">
                <thead style="font-size: 12px;" class="ungu">
                    <tr class="size">
                        <th>#</th>
                        <th >Nomor Invoice</th>
                        <th >Plat Nomor Armada</th>
                        <th>Waktu Mulai</th>
                        <th >Waktu Selesai</th>
                        <th >Durasi Jam</th>
                        <th>Harga</th>
                        <th >Status</th>
                        <th >Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Selama hasil data ada dari sql  -->
                    
                    @foreach($bookingArmadas as $bookingArmada)
                    <tr class="size2 align-middle">
                        {{-- <td>{{ $loop->iteration }}</td> --}}
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $bookingArmada->booking->no_invoice }}</td>
                        <td>{{ $bookingArmada->armada->plat_nomor }}</td>
                        <td>{{ $bookingArmada->waktu_mulai}}</td>
                        <td>{{ $bookingArmada->waktu_selesai}}</td>
                        <td>{{ $bookingArmada->durasi_jam }}</td>
                        <td>{{ $bookingArmada->harga }}</td>
                        <td>{{ $bookingArmada->status }}</td>
                        <td>
                            <div class="d-flex justify-content-around">
                                @can('superadmin')
                                <a href="{{ route('booking_armada.edit', $bookingArmada->id) }}" type="button" class="btn btn-primary btn-sm">
                                    <i class="ri-pencil-fill "></i>
                                </a>
                                @endcan
                                <a href="{{ route('booking_armada.show', $bookingArmada->id) }}" type="button" class="btn btn-info btn-sm">
                                    <i class="ri-eye-line "></i>
                                </a>
                                @can('superadmin')
                                <form action="{{ route('booking_armada.destroy', $bookingArmada->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onClick="return confirm('Are You Sure Want to Delete this item? It will also possibly delete ')">
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>

                    @endforeach

                </tbody>
            </table>
    </figure>
<!-- Table -->
@endsection


@section('bottom_links')
    @include('partials.datatables_bottom_links')
@endsection
