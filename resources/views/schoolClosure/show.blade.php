@extends('layouts.app')

@section('content')

<section class="container">
    <h1>سجل الإغلاق</h1>
    @if($closure->deleted == true)
        <p class="text-danger">هذا السجل محذوف ولن يظهر في أيّ من الإحصائيات أو الجداول.</p>
    @endif
    <a onclick="goBack()" class="btn btn-info">رجوع</a>
    @if($closure->deleted == true)
        @if(Auth::user()->account_type == 1)
            <form action="{{route('schoolClosure.destroy', $closure->id)}}" method="POST"
                style="display:inline;">
                @method('DELETE')
                @csrf
                <button type="button" class="btn btn-primary"
                onclick="undeleter(this, 'هل انت متأكد من رغبتك في استرجاع هذا السجل؟')"
                >استرجاع</button>
            </form>
        @endif
    @endif
    @if(Auth::user()->id == $closure->user_id)
        <a href="/schoolClosure/{{$closure->id}}/edit" class="btn btn-warning">تحديث السجل</a>
    @endif
    @if((Auth::user()->account_type == 2) && ($closure->deleted == false) && ($closure->user->directorate_id == Auth::user()->directorate_id))
        <form action="{{route('schoolClosure.destroy', $closure->id)}}" method="POST"
            style="display:inline;">
            @method('DELETE')
            @csrf
            <button type="button" class="btn btn-danger"
            onclick="deleter(this, 'هل انت متأكد من رغبتك في حذف هذا السجل؟')"
            >حذف</button>
        </form>
    @endif

    <br/><br/>

    <table class="table table-hover text-right table-striped">
        @if((Auth::user()->account_type == 1) && isset($schoolClosure->last_editor))
            <tr class="text-danger">
                <td scope="row">أخر تعديل بوساطة</td>
                <td>حساب رقم {{$schoolClosure->last_editor}}</td>
            </tr>
            @if(isset($schoolClosure->last_editor_ip))
                <tr class="text-danger">
                    <td scope="row">أخر تعديل بوساطة</td>
                    <td>عنوان إنترنت {{$schoolClosure->last_editor_ip}}</td>
                </tr>
            @endif
        @endif
        <tr>
            <td scope="row">رقم سجل الإغلاق</td>
            <td>{{$closure->id}}</td>
        </tr>
        <tr>
            <td scope="row">نوع الإغلاق</td>
            <td>
                @if($closure->grade == 15) إغلاق كامل
                @elseif($closure->grade == 14) إغلاق مع تواجد الإدارة
                @elseif($closure->grade == 13) إغلاق مع تواجد الإدارة والمعلمين
                @else إغلاق صف {{$closure->grade}} شعبة رقم {{$closure->grade_section}}
                @endif
            </td>
        </tr>
        <tr>
            <td scope="row">بدأ الإغلاق في</td>
            <td>{{$closure->closure_date}}</td>
        </tr>
        <tr>
            <td scope="row">الحالة</td>
            <td>
                @if($closure->reopening_date != null)
                    أعيد فتح المدرسة في {{$closure->reopening_date}}
                @else
                    ما زال الإغلاق ساريًا
                @endif
            </td>
        </tr>
        <tr>
            <td scope="row">ملاحظات</td>
            <td>{{$closure->notes}}</td>
        </tr>
    </table>
</section>


<section class="container">
    <h1>معلومات المدرسة</h1>
    <table class="table table-hover text-right table-striped">
        <tr>
            <td scope="row">رقم ملف المدرسة</td>
            <td>{{$info['school']->id}}</td>
        </tr>
        <tr>
            <td scope="row">الرقم الوطني</td>
            <td>{{$info['user']->gov_id}}</td>
        </tr>
        <tr>
            <td scope="row">اسم المدرسة</td>
            <td>{{$info['user']->name}}</td>
        </tr>
        <tr>
            <td scope="row">رقم الهاتف</td>
            <td dir="ltr">{{$info['user']->phone_primary}}</td>
        </tr>
        <tr>
            <td scope="row">رقم هاتف إضافي</td>
            <td dir="ltr">{{$info['user']->phone_secondary}}</td>
        </tr>
        <tr>
            <td scope="row">البريد الإلكتروني</td>
            <td dir="ltr">{{$info['user']->email}}</td>
        </tr>
        <tr>
            <td scope="row">الحالة</td>
            <td>
                @if(!$current->isEmpty)
                    @if($current->grade == 15) مغلقة بالكامل
                    @elseif($current->grade == 14) مغلقة مع تواجد الإدارة
                    @elseif($current->grade == 13) مغلقة مع تواجد الإدارة والمعلمين
                    @else مغلقة جزئيًا
                    @endif
                @else دوام طبيعي
                @endif
            </td>
        </tr>
        <tr>
            <td scope="row">المديرية</td>
            <td>{{$info['directorate']->name_ar}}</td>
        </tr>
        <tr>
            <td scope="row">اسم مدير المدرسة</td>
            <td>{{$info['school']->head_of_school}}</td>
        </tr>
        <tr>
            <td scope="row">فترة الدوام</td>
            <td>
                @if($info['school']->second_shift == true) مسائي
                @elseif($info['school']->second_shift == false) صباحي
                @endif
            </td>
        </tr>
        <tr>
            <td scope="row">عدد الغرف الصفية</td>
            <td>{{$info['school']->number_of_classrooms}}</td>
        </tr>
        <tr>
            <td scope="row">عدد الطلاب الكلي</td>
            <td>{{$info['school']->total_female_students + $info['school']->total_female_students}}</td>
        </tr>
        <tr>
            <td scope="row">عدد الطاقم الكلي</td>
            <td>{{$info['school']->total_male_staff + $info['school']->total_female_staff}}</td>
        </tr>
        <tr>
            <td scope="row">المرحلة الدراسية</td>
            <td>
                @if($info['school']->oldest_class > 9)
                    ثانوي
                @elseif($info['school']->oldest_class > 4)
                    أساسية عليا
                @elseif(($info['school']->oldest_class < 5) && ($info['school']->oldest_class > 0))
                    أساسية دنيا
                @else
                    غير معروف
                @endif
            </td>
        </tr>
    </table>
</section>

@if(sizeof($other) != 0)
    <section class="container">
        <h2>التقرير الزمني للإغلاقات</h2>
        <table class="table table-hover text-right table-striped">
            <tr>
                <th scope="col">رقم السجل</th>
                <th scope="col">تاريخ الإغلاق</th>
                <th scope="col">تاريخ إنهاء الإغلاق</th>
                <th scope="col">معلومات الإغلاق</th>
                <th scope="col">الحالة</th>
                <th scope="col">المتأثرون بالإغلاق</th>
            </tr>
            @foreach($other as $x)
                <tr>
                    <td>{{$x->id}}</td>
                    <td>{{$x->closure_date}}</td>
                    <td>{{$x->reopening_date ?? ''}}</td>
                    <td>
                        @if($closure->grade == 15) إغلاق كامل
                        @elseif($closure->grade == 14) إغلاق مع تواجد الإدارة
                        @elseif($closure->grade == 13) إغلاق مع تواجد الإدارة والمعلمين
                        @else إغلاق صف {{$closure->grade}} شعبة {{$closure->grade_section}}
                        @endif
                    </td>
                    <td>
                        @if($x->reopening_date != null) انتهى الإغلاق
                        @else الإغلاق مستمر
                        @endif
                    </td>
                    <td>{{$x->affected_students ?? ''}}</td>
                </tr>
            @endforeach 
        </table>
    </section>
@endif

@endsection