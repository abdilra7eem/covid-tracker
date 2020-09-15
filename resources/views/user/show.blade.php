@extends('layouts.app')

@section('content')

<section class="container">
    <h1>معلومات الحساب</h1>
    @if($user->active == false)
        <p class="text-danger">هذا الحساب معطل، ولن يتمكن من عمل أيّ تعديلات على أيّ من السجلات.</p>
    @endif
    @if( ($user->account_type == 3) && ($user->school == null) )
        <p class="text-danger">هذا الحساب لمدرسة ليس لها ملف.</p>
    @endif
    <a onclick="goBack()" class="btn btn-info">رجوع</a>
    @if ($user->id != 1)
        @if((Auth::user()->id == 1) || (($user->account_type != 1) && (Auth::user()->account_type == 1)) || ( (Auth::user()->account_type == 2) && ($user->account_type != 2) && ($user->directorate_id == Auth::user()->directorate_id)))
            <form action="{{route('user.destroy', $user->id)}}" method="POST"
                style="display:inline;">
                @method('DELETE')
                @csrf
                @if($user->active == true)
                    <button type="button" class="btn btn-secondary"
                    onclick="accountDisable(this, 'إذا عطّلت الحساب، لن يتمكن صاحب الحساب من إنشاء أو تعديل أو الوصول إلى أيّ بيانات مخزنة في نظام تتبع حالات كورونا.')"
                    >تعطيل الحساب</button>
                @else
                    <button type="button" class="btn btn-primary"
                    onclick="accountEnable(this, 'إذا فعّلت الحساب، سيتمكن صاحب الحساب من إنشاء و تعديل و الوصول إلى البيانات التي كان باستطاعته الوصول إليها قبل تعطيل حسابه.')"
                    >تفعيل الحساب</button>
                @endif
            </form>
            <a href="/user/{{$user->id}}/edit" class="btn btn-warning">تعديل</a>
            <br/><br/>
        @endif
    @endif
    <table class="table table-hover text-right table-striped">
        @if((Auth::user()->account_type == 1) && isset($user->last_editor))
            <tr class="text-danger">
                <td scope="row">أخر تعديل بوساطة</td>
                <td>حساب رقم {{$user->last_editor}}</td>
            </tr>
            @if(isset($user->last_editor_ip))
                <tr class="text-danger">
                    <td scope="row">أخر تعديل بوساطة</td>
                    <td>عنوان إنترنت {{$user->last_editor_ip}}</td>
                </tr>
            @endif
        @endif
        <tr>
            <td scope="row">المعرف الفريد</td>
            <td>{{$user->id}}</td>
        </tr>
        <tr>
            <td scope="row">
                @if($user->account_type == 3)
                    اسم المدرسة
                @else
                    اسم المشرف
                @endif
            </td>
            <td>{{$user->name}}</td>
        </tr>
        <tr>
            <td scope="row">رقم الهاتف</td>
            <td dir="ltr">{{$user->phone_primary}}</td>
        </tr>
        <tr>
            <td scope="row">رقم هاتف إضافي</td>
            <td dir="ltr">{{$user->phone_secondary}}</td>
        </tr>
        <tr>
            <td scope="row">البريد الإلكتروني</td>
            <td dir="ltr">{{$user->email}}</td>
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
                    @elseif($user->account_type == 3) مدرسة
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