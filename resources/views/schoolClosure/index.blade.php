@extends('layouts.app')

@section('content')
    {{-- {{dd($schools)}} --}}
    <section class="container">
        <table class="table table-hover text-right">
            <tr>
                <th scope="col">الرقم الوطني</th>
                <th scope="col">الاسم</th>
                <th scope="col">الهاتف الرئيسي</th>
                <th scope="col">اسم مدير المدرسة</th>
                <th scope="col">الدوام</th>
                <th scope="col">نوع الإغلاق</th>
            </tr>
            @foreach($schools as $school)
                @if( ($type != 'partial') || ($school->grade < 13) )
                    <tr class="
                        @if($school->grade > 12) table-danger 
                        @else table-warning
                        @endif
                    ">
                        <td>{{$school->gov_id}}</td>
                        <td>{{$school->name}}</td>
                        <td>{{$school->phone_primary}}</td>
                        <td>
                            {{$school->head_of_school}}
                        </td>
                        <td>
                            @if($school->second_shift == true) مسائي
                            @else صباحي @endif
                        </td>
                        <td>
                            @if($school->grade == 14) كامل
                            @elseif($school->grade == 13) جميع الصفوف
                            @else جزئي
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach 
        </table>
    </section>
@endsection