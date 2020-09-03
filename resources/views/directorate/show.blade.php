@extends('layouts.app')

@section('content')

<section class="container">
    <table class="table table-hover text-right table-striped">
        <tr>
            <td scope="row">المعرف الفريد</td>
            <td>{{$directorate->name}}</td>
        </tr>
        <tr>
            <td scope="row">الاسم بالعربية</td>
            <td>{{$directorate->name_ar}}</td>
        </tr>
        <tr>
            <td scope="row">رقم الهاتف</td>
            <td>{{$directorate->phone_number}}</td>
        </tr>
        <tr>
            <td scope="row">البريد الإلكتروني</td>
            <td>{{$directorate->email}}</td>
        </tr>
        <tr>
            <td scope="row">اسم مدير المديرية</td>
            <td>{{$directorate->head_of_directorate}}</td>
        </tr>
        <tr>
            <td scope="row">عدد المدارس</td>
            <td>{{$directorate->school_count}}</td>
        </tr>
    </table>
</section>

@endsection