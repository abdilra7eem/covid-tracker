@extends('layouts.app')

@section('content')
    {{-- {{dd($schools)}} --}}
    <section class="container">
        @if(Auth::user()->account_type == 3)
            <a href="/schoolClosure/create" class="btn btn-success covid-form-button">إنشاء سجل إغلاق جديد</a>
            <br/>
        @endif
        <table class="table table-hover text-right">
            <tr>
                <th scope="col">رقم السجل</th>
                <th scope="col">الرقم الوطني</th>
                <th scope="col">الاسم</th>
                <th scope="col">الهاتف الرئيسي</th>
                <th scope="col">اسم مدير المدرسة</th>
                <th scope="col">الدوام</th>
                <th scope="col">نوع الإغلاق</th>
                <th scope="col">تاريخ بدء الإغلاق</th>                
                <th scope="col">الطلبة المتأثرون</th>
            </tr>
            @foreach($schools as $school)
                <tr class="
                    @if($school->grade > 12) table-danger 
                    @else table-warning
                    @endif
                covid-index-row"
                onclick="goTo('schoolClosure', {{$school->id}})"
                >
                    <td>{{$school->id}}</td>
                    <td>{{$school->user['gov_id']}}</td>
                    <td>{{$school->user['name']}}</td>
                    <td dir="ltr">{{$school->user['phone_primary']}}</td>
                    <td>
                        {{$school->user->school['head_of_school']}}
                    </td>
                    <td>
                        @if($school->user->school['second_shift'] == true) مسائي
                        @else صباحي @endif
                    </td>
                    <td>
                        @if($school->grade  > 12) كلي
                        @else جزئي
                        @endif
                    </td>
                    <td>{{$school->closure_date}}</td>
                    <td>{{$school->affected_students ?? ''}}</td>
                </tr>
            @endforeach 
        </table>
    </section>
    @if($schools->links() != null)
        <section class="container">
            {{ $schools->appends(['type' => $type])->links() ?? ''}}
        </section>
    @endif
@endsection