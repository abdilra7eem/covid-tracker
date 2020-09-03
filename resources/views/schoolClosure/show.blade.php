@extends('layouts.app')

@section('content')

<section class="container">
    <h1>سجل الإغلاق</h1>
    <table class="table table-hover text-right table-striped">
        <tr>
            <td scope="row">رقم سجل الإغلاق</td>
            <td>{{$closure->id}}</td>
        </tr>
        <tr>
            <td scope="row">نوع الإغلاق</td>
            <td>
                @if($closure->grade == 14) إغلاق كامل
                @elseif($closure->grade == 13) إغلاق مع تواجد الإدارة
                @else إغلاق الصف رقم {{$closure->grade}} شعبة رقم {{$closure->grade_section}}
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
    </table>
</section>


<section class="container">
    <h1>معلومات المدرسة</h1>
    <table class="table table-hover text-right table-striped">
        <tr>
            <td scope="row">رقم ملف المدرسة</td>
            <td>{{$info['user']->school->id}}</td>
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
            <td>{{$info['user']->phone_primary}}</td>
        </tr>
        <tr>
            <td scope="row">رقم هاتف إضافي</td>
            <td>{{$info['user']->phone_secondary}}</td>
        </tr>
        <tr>
            <td scope="row">البريد الإلكتروني</td>
            <td>{{$info['user']->email}}</td>
        </tr>
        <tr>
            <td scope="row">الحالة</td>
            <td>
                @if(!$current->isEmpty)
                    @if($current->grade == 14) مغلقة بالكامل
                    @elseif($current->grade == 13) مغلقة مع تواجد الإدارة
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
                <th scope="col">الصف</th>
                <th scope="col">الشعبة</th>
                <th scope="col">الحالة</th>
                <th scope="col">المتأثرون بالإغلاق</th>
            </tr>
            @foreach($other as $x)
                <tr>
                    <td>{{$x->id}}</td>
                    <td>{{$x->closure_date}}</td>
                    <td>{{$x->reopening_date ?? ''}}</td>
                    <td>{{$x->grade}}</td>
                    <td>{{$x->grade_section}}</td>
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