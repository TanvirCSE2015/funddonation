@extends('layouts.admin_template')
@section('title')
<title>Type List | Admin </title>
@endsection
@section('main_content')
<!-- Basic Bootstrap Table -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="row">
            <div class="col-sm-6">
                <h5 class="card-header">ডোনারের ধরণ</h5>
            </div>
            <div class="col-sm-6 pull-right" style="padding:1rem 2rem;text-align:right;">
                <a href="{{route('admin.addtype')}}" class="btn btn-info text-white" style="width:152px;" >নতুন যোগ করুন</a>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
            <thead>
                <tr>
                <th>সিরিয়াল</th>
                <th>নাম</th>
                <th></th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @foreach($types as $row)
            <tr>
                <td>{{$row->type_id }}</td>
                <td>{{$row->type_name }}</td>
                <td style="text-align:right;">
                    <div class="btn-group">
                        <a href="{{route('admin.edittype',$row->type_id)}}" class="btn btn-success"><i class="bx bx-edit"></i></a>
                        <a href="{{route('admin.deletetype',$row->type_id)}}" class="btn btn-danger"><i class="bx bx-trash"></i></a>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
            </table>
        </div>
    </div>
</div>
    <!--/ Basic Bootstrap Table -->

@endsection