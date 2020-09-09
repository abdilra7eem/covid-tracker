@extends('layouts.app')

@section('content')

{{-- {{dd($other)}} --}}

<section class="container">
    <h1>معلومات الحالة</h1>
    <table class="table table-hover text-right table-striped">
        <tr>
            <td scope="row">رقم سجل الحالة</td>
            <td>{{$incident->id}}</td>
        </tr>
        <tr>
            <td scope="row">اسم صاحب الحالة</td>
            <td>{{$incident->person_name}}</td>
        </tr>
        <tr>
            <td scope="row">رقم الهوية</td>
            <td>{{$incident->person_id}}</td>
        </tr>
        <tr>
            <td scope="row">الجنس</td>
            <td>
                @if($incident->male == true)
                    ذكر
                @else
                    أنثى
                @endif
            </td>
        </tr>
        <tr>
            <td scope="row">صفته</td>
            <td>
                @if($incident->grade == 14)
                    إداري
                @elseif($incident->grade == 13)
                    معلم/ة
                @else
                    طالب/ة
                @endif
            </td>
        </tr>
        @if($incident->grade < 13)
            <tr>
                <td scope="row">الصف</td>
                <td>{{$incident->grade}}</td>
            </tr>
            <tr>
                <td scope="row">الشعبة</td>
                <td>{{$incident->grade_section}}</td>
            </tr>
        @endif
        @if(isset($incident->closed_at))
            <tr>
                <td scope="row">نوع الحالة</td>
                <td>
                    مغلقة: 
                    @if($incident->close_type == 1)
                        اشتباه خاطئ
                    @elseif($incident->close_type == 2)
                        تعافي
                    @elseif($incident->close_type == 3)
                        وفاة
                    @endif
                </td>
            </tr>
            <tr>
                <td scope="row">تاريخ إغلاق الحالة</td>
                <td>{{$incident->closed_at}}</td>
            </tr>
        @elseif(isset($incident->confirmed_at))
            <tr>
                <td scope="row">نوع الحالة</td>
                <td>مؤكدة</td>
            </tr>
            <tr>
                <td scope="row">تاريخ تأكيد الحالة</td>
                <td>{{$incident->confirmed_at}}</td>
            </tr>
        @else
            <tr>
                <td scope="row">نوع الحالة</td>
                <td>
                    اشتباه: 
                    @if($incident->suspect_type == 1)
                        شخصي/ولي أمر
                    @elseif($incident->suspect_type == 2)
                        طبيب خاص
                    @elseif($incident->suspect_type == 3)
                        جهة حكومية
                    @endif
                </td>
            </tr>
            <tr>
                <td scope="row">تاريخ الاشتباه</td>
                <td>{{$incident->suspected_at}}</td>
            </tr>
        @endif
        <tr>
            <td scope="row">رقم الهاتف</td>
            <td>{{$incident->person_phone_primary}}</td>
        </tr>
        @if(isset($incident->person_phone_secondary))
            <tr>
                <td scope="row">رقم هاتف إضافي</td>
                <td>{{$incident->person_phone_secondary}}</td>
            </tr>
        @endif
        <tr>
            <td scope="row">اسم المدرسة</td>
            <td>{{$incident->user->name}}</td>
        </tr>
        <tr>
            <td scope="row">رقم هاتف المدرسة</td>
            <td>{{$incident->user->phone_primary}}</td>
        </tr>
        @if(isset($incident->notes))
            <tr>
                <td scope="row">ملاحظات</td>
                <td>{{$incident->notes}}</td>
            </tr>
        @endif
    </table>
</section>

<section  class="container">
    <h2>سجل الحالة</h2>
    <table class="table table-hover text-right table-striped">
        <tr>
            <th scope="column">التاريخ</th>
            <th scope="column">الحدث</th>
            <th scope="column">تفاصيل</th>
        </tr>
        @if(isset($incident->closed_at))
            <tr>
                <td scope="row">{{$incident->closed_at}}</td>
                <td>إغلاق حالة</td>
                <td>
                    @if($incident->close_type == 1)
                        اشتباه خاطئ، الشخص سليم
                    @elseif($incident->close_type == 2)
                        تعافى الشخص المعني
                    @elseif($incident->close_type == 3)
                        توفي صاحب الحالة
                    @endif
                </td>
            </tr>
        @endif
        @if(isset($incident->confirmed_at))
            <tr>
                <td scope="row">{{$incident->confirmed_at}}</td>
                <td>تأكيد حالة</td>
                <td>
                </td>
            </tr>
        @endif
        @if(isset($incident->suspected_at))
            <tr>
                <td scope="row">{{$incident->suspected_at}}</td>
                <td>اشتباه</td>
                <td>
                    @if($incident->suspect_type == 1)
                        اشتباه شخصي أو من الأهل
                    @elseif($incident->suspect_type == 2)
                        اشتباه طبيب خاص
                    @elseif($incident->suspect_type == 3)
                        اشتباه جهة حكومية ذات علاقة
                    @endif
                </td>
            </tr>
        @endif
    </table>
</section>

@if(sizeof($other) != 0)
    <section class="container">
        <h2>التقرير الزمني للشخص</h2>
        <table class="table table-hover text-right table-striped">
            <tr>
                <th scope="col">رقم السجل</th>
                <th scope="col">تاريخ الاشتباه</th>
                <th scope="col">نوع الاشتباه</th>
                <th scope="col">تاريخ تأكيد الحالة</th>
                <th scope="col">تاريخ إغلاق الحالة</th>
                <th scope="col">نوع الإغلاق</th>
                {{-- <th scope="col" style="width: 50% !important;">ملاحظات</th> --}}
            </tr>
            @foreach($other as $x)
                <tr>
                    <td>{{$x->id}}</td>
                    <td>{{$x->suspected_at}}</td>
                    <td>
                        @if($x->suspect_type == 1) شخصي/الأهل
                        @elseif($x->suspect_type == 2) طبيب خاص
                        @elseif($x->suspect_type == 3) جهة حكومية
                        @endif
                    </td>
                    <td>{{$x->confirmed_at}}</td>
                    <td>{{$x->closed_at}}</td>
                    <td>
                        @if($x->close_type == 1) اشتباه خاطئ
                        @elseif($x->close_type == 2) شفاء
                        @elseif($x->close_type == 3) وفاة
                        @endif
                    </td>
                    {{-- <td>{{$x->notes}}</td> --}}
                </tr>
            @endforeach 
        </table>
    </section>
@endif

@endsection