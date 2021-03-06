@extends('layouts.app')

@section('content')

<section class="container">
    @if(Auth::user()->id == 1)
        <a href="/directorate/create" class="btn btn-success covid-form-button">
            إنشاء مديرية جديدة
        </a>
        <br/>
    @endif
    <table class="table table-hover text-right table-striped">
        <tr>
            <th scope="col">الرقم</th>
            <th scope="col">المعرف الفريد</th>
            <th scope="col">الاسم بالعربية</th>
            <th scope="col">رقم الهاتف</th>
            <th scope="col">البريد الإلكتروني</th>
            <th scope="col">اسم مدير المديرية</th>
            <th scope="col">عدد المدارس</th>            
        </tr>
        @foreach($directorates as $directorate)
            <tr class="covid-index-row" onclick="goTo('directorate', {{$directorate->id}})">
                <td>{{$directorate->id}}</td>
                <td>{{$directorate->name}}</td>
                <td>{{$directorate->name_ar}}</td>
                <td dir="ltr">{{$directorate->phone_number}}</td>
                <td dir="ltr">{{$directorate->email}}</td>
                <td>{{$directorate->head_of_directorate}}</td>
                <td>{{$directorate->school_count}}</td>
            </tr>
        @endforeach 
    </table>
    {{-- {{dd($directorates)}} --}}
</section>

@endsection