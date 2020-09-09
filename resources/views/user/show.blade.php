@extends('layouts.app')

@section('content')

<section class="container">
    <h1>معلومات الحساب</h1>
    @if($user->active == false)
        <p class="text-danger">هذا الحساب معطل، ولن يتمكن من عمل أيّ تعديلات على أيّ من السجلات.</p>
    @endif
    @if((Auth::user()->account_type == 1) || ( (Auth::user()->account_type == 2) && ($user->directorate_id == Auth::user()->directorate_id) ))
        <form action="{{route('user.destroy', $user->id)}}" method="POST"
            style="display:inline;">
            @method('DELETE')
            @csrf
            @if($user->active == true)
                <button type="submit" class="btn btn-secondary">تعطيل الحساب</button>
            @else
                <button type="submit" class="btn btn-primary">تفعيل الحساب</button>
            @endif
        </form>
        <a href="/user/edit/{{$user->id}}" class="btn btn-warning">تعديل</a>
        <br/><br/>
    @endif
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