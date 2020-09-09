@extends('layouts.app')

@section('content')
    <section class="container">
        @if((Auth::user()->account_type == 1) || (Auth::user()->account_type == 2))
            <a href="/user/create" class="btn btn-success covid-form-button">إنشاء حساب مستخدم جديد</a>
            <br/>
        @endif
        <table class="table table-hover text-right">
            <tr>
                <th scope="col">رقم الحساب</th>
                <th scope="col">رقم الهوية</th>
                <th scope="col">الاسم</th>
                <th scope="col">Email</th>
                <th scope="col">الهاتف الرئيسي</th>
                {{-- <th scope="col">الهاتف الثاني</th> --}}
                <th scope="col">نوع الحساب</th>
                {{-- <th scope="col">مفعل ✓</th>                 --}}
            </tr>
            @foreach($users as $user)
                <tr class="
                    @if($user->active == false) table-secondary @endif
                    @if($user->account_type == 1) table-primary @endif
                ">
                    <td>{{$user->id}}</td>
                    <td>{{$user->gov_id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone_primary}}</td>
                    {{-- <td>{{$user->phone_secondary}}</td> --}}
                    <td>
                        @if($user->account_type == 1) إدارة البرنامج
                        @elseif($user->account_type == 2) مشرف
                        @else غير معروف
                        @endif
                    </td>
                    {{-- <td>
                        @if($user->active == true) ✓
                        @else ✗
                        @endif
                    </td> --}}
            @endforeach 
        </table>
    </section>
    <section class="container">
        {{ $users->links() }}
    </section>
@endsection