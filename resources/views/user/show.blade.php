@extends('layouts.app')

@section('content')

<section class="container">
    <table class="table table-hover text-right table-striped">
        {{-- {{dd($user)}} --}}
        <tr>
            <td scope="row">المعرف الفريد</td>
            <td>{{$user->id}}</td>
        </tr>
        <tr>
            <td scope="row">اسم المشرف</td>
            <td>{{$user->name}}</td>
        </tr>
        <tr>
            <td scope="row">رقم الهاتف</td>
            <td>{{$user->phone_primary}}</td>
        </tr>
        <tr>
            <td scope="row">رقم هاتف إضافي</td>
            <td>{{$user->phone_secondary}}</td>
        </tr>
        <tr>
            <td scope="row">البريد الإلكتروني</td>
            <td>{{$user->email}}</td>
        </tr>
        @if((Auth::user()->account_type == 1) || (Auth::user()->account_type == 2))
            <tr>
                <td scope="row">رقم الهوية</td>
                <td>{{$user->gov_id}}</td>
            </tr>
            <tr>
                <td scope="row">نوع الحساب</td>
                <td>
                    @if($user->account_type == 1) إدارة البرنامج
                    @elseif($user->account_type == 2) مشرف
                    @endif
                </td>
            </tr>
            <tr>
                <td scope="row">حالة الحساب</td>
                <td>
                    @if($user->active == true) مفعل
                    @else معطل
                    @endif
                </td>
            </tr>
            <tr>
                <td scope="row">المديرية</td>
                <td>{{$user->directorate->name_ar}}</td>
            </tr>
        @endif
    </table>
</section>

@endsection