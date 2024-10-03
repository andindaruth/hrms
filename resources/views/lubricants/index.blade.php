@extends('layouts.app')

@section('title', 'Lubricants ')
@section('page_title', 'Lubricants')

@section('bread_crumb')
    <ol class="breadcrumb float-sm-right">
        <a href="{{ route('lubs.create') }}" class="btn float-right bg-success"><i class="fa fa-plus"></i> New Lubricant
        </a>
    </ol>
@endsection

@section('main_content')

    <div class="col-sm-12">
        <div class="card card-success card-outline">

            <div class="card-body table-responsive">
                <table id="example2" class="table table-hover table-head-fixed table-sm table-striped">
                    <thead>
                        <tr>
                            
                            <th>Type</th>
                            <th>Balance(litres)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @unless ($lubs->isEmpty())
                            @foreach ($lubs as $lub)                                

                                <tr class="text-nowrap">
                                    <td><a href="{{ route('lubs.edit', ['lub' => $lub]) }}">{{ $lub->type }}</a>
                                    </td>
                                    <td>{{ $lub->balance }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="border-gray-300">
                                <td colspan="10">
                                    <p class="text-center">No lubricants Found</p>
                                </td>
                            </tr>
                        @endunless
                    </tbody>
                </table>
            </div> <!-- /.card-body -->
        </div>
    </div>

@endsection
