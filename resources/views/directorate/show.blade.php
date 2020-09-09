@extends('layouts.app')

@section('content')
<section class="container">
    <h1>عرض معلومات المديرية</h1>
    @if(Auth::user()->account_type == 1)
        <a href="/directorate/create" class="btn btn-success">إنشاء ملف جديد</a>
        <a href="/directorate/edit/{{$directorate->id}}" class="btn btn-warning">تعديل</a>
            <form action="{{route('directorate.destroy', $directorate->id)}}" method="POST"
                style="display:inline;">
                @method('DELETE')
                @csrf
                @if($directorate->active == true)
                    <button type="submit" class="btn btn-danger">حذف المديرية</button>
                @endif
            </form>
        {{-- <a href="/directorate/delete/{{$directorate->id}}" class="btn btn-danger">حذف</a> --}}
        <br/><br/>
    @endif

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