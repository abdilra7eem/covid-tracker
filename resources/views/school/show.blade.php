@extends('layouts.app')

@section('content')

<section class="container">
    <table class="table table-hover text-right table-striped">
        <tr>
            <td scope="row">الرقم التسلسلي للحساب</td>
            <td>{{$school->user->id}}</td>
        </tr>
        <tr>
            <td scope="row">الرقم ملف المدرسة</td>
            <td>{{$school->id}}</td>
        </tr>
        <tr>
            <td scope="row">اسم المدرسة</td>
            <td>{{$school->user->name}}</td>
        </tr>
        <tr>
            <td scope="row">رقم الهاتف</td>
            <td>{{$school->user->phone_primary}}</td>
        </tr>
        <tr>
            <td scope="row">رقم هاتف إضافي</td>
            <td>{{$school->user->phone_secondary}}</td>
        </tr>
        <tr>
            <td scope="row">البريد الإلكتروني</td>
            <td>{{$school->user->email}}</td>
        </tr>
        <tr>
            <td scope="row">الرقم الوطني</td>
            <td>{{$school->user->gov_id}}</td>
        </tr>
        <tr>
            <td scope="row">نوع الحساب</td>
            <td>مدرسة</td>
        </tr>
        <tr>
            <td scope="row">حالة الحساب</td>
            <td>
                @if($school->user->active == true) مفعل
                @else معطل
                @endif
            </td>
        </tr>
        <tr>
            <td scope="row">المديرية</td>
            <td>{{$school->user->directorate->name_ar}}</td>
        </tr>
        <tr>
            <td scope="row">الملكية</td>
            <td>
                @if($school->rented == true) مستأجرة
                @elseif($school->rented == false) ملك
                @endif
            </td>
        </tr>
        <tr>
            <td scope="row">اسم مدير المدرسة</td>
            <td>{{$school->head_of_school}}</td>
        </tr>
        <tr>
            <td scope="row">فترة الدوام</td>
            <td>
                @if($school->second_shift == true) مسائي
                @elseif($school->second_shift == false) صباحي
                @endif
            </td>
        </tr>
        <tr>
            <td scope="row">سنة البناء</td>
            <td>{{$school->building_year + 1780}}</td>
        </tr>
        <tr>
            <td scope="row">عمر المبنى بالسنوات</td>
            <td>{{241 - $school->building_year}}</td>
        </tr>
        <tr>
            <td scope="row">عدد الغرف الصفية</td>
            <td>{{$school->number_of_classrooms}}</td>
        </tr>
        <tr>
            <td scope="row">عدد الطلاب الذكور</td>
            <td>{{$school->total_male_students}}</td>
        </tr>
        <tr>
            <td scope="row">عدد الطالبات الإناث</td>
            <td>{{$school->total_female_students}}</td>
        </tr>
        <tr>
            <td scope="row">عدد الطلاب الكلي</td>
            <td>{{$school->total_female_students + $school->total_female_students}}</td>
        </tr>
        <tr>
            <td scope="row">نوع المدرسة</td>
            <td>
                @if(($school->total_female_students > 0) && ($school->total_male_students > 0))
                    مختلطة
                @elseif(($school->total_female_students == 0) && ($school->total_male_students > 0))
                    ذكور
                @elseif(($school->total_female_students > 0) && ($school->total_male_students == 0))
                    إناث
                @else
                    غير معروف
                @endif
            </td>
        </tr>
        <tr>
            <td scope="row">عدد الطاقم الذكور</td>
            <td>{{$school->total_male_staff}}</td>
        </tr>
        <tr>
            <td scope="row">عدد الطاقم الإناث</td>
            <td>{{$school->total_female_staff}}</td>
        </tr>
        <tr>
            <td scope="row">عدد الطاقم الكلي</td>
            <td>{{$school->total_male_staff + $school->total_female_staff}}</td>
        </tr>
        <tr>
            <td scope="row">أصغر صف في المدرسة</td>
            <td>{{$school->youngest_class}}</td>
        </tr>
        <tr>
            <td scope="row">أكبر صف في المدرسة</td>
            <td>{{$school->oldest_class}}</td>
        </tr>
        <tr>
            <td scope="row">المرحلة الدراسية</td>
            <td>
                @if($school->oldest_class > 9)
                    ثانوي
                @elseif($school->oldest_class > 4)
                    أساسية عليا
                @elseif(($school->oldest_class < 5) && ($school->oldest_class > 0))
                    أساسية دنيا
                @else
                    غير معروف
                @endif
            </td>
        </tr>
    </table>
</section>


@endsection