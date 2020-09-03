@extends('layouts.app')

@section('content')
    <section class="container">
        <table class="table table-hover text-right">
            <tr>
                <th scope="col">رقم السجل</th>
                <th scope="col">رقم الهوية</th>
                <th scope="col">الاسم</th>
                <th scope="col">رقم الهاتف</th>
                <th scope="col">الصف</th>
                <th scope="col">الجنس</th>
                <th scope="col">المدرسة</th>
                <th scope="col">الحالة</th>
                <th scope="col">خيارات</th>
            </tr>
            @foreach($incidents as $incident)
                @if(isset($incident->closed_at))
                    @if($incident->close_type == 1)
                        @php $condition = 'not_covid' @endphp
                    @elseif($incident->close_type == 2)
                        @php $condition = 'recovered' @endphp
                    @elseif($incident->close_type == 3)
                        @php $condition = 'died' @endphp
                    @endif
                @elseif(isset($incident->confirmed_at))
                    @php $condition = 'confirmed' @endphp
                @elseif(isset($incident->suspected_at))
                    @php $condition = 'suspected' @endphp
                @else
                    @php $condition = '' @endphp
                @endif
                <tr class="@switch($condition ?? '')
                                @case('recovered')
                                    table-success
                                    @break
                                @case('died')
                                    table-danger
                                    @break
                                @case('confirmed')
                                    table-warning
                                    @break
                                @case('suspected')
                                    table-info
                                    @break
                                @default
                                    @break
                            @endswitch
                ">
                    <td>{{$incident->id}}</td>
                    <td>{{$incident->person_id}}</td>
                    <td>{{$incident->person_name}}</td>
                    <td>{{$incident->person_phone_primary}}</td>
                    <td>
                        @if($incident->grade == 14)
                            إدارة
                        @elseif($incident->grade == 13)
                            معلم/ة
                        @else
                            {{$incident->grade}}
                        @endif
                    </td>
                    <td>@if($incident->male) ذكر @else أنثى @endif</td>
                    <td>{{isset($incident->user['name'])?$incident->user['name']:""}}</td>
                    <td>
                        @switch($condition)
                            @case('not_covid')
                                اشتباه خاطئ
                                @break
                            @case('recovered')
                                شفاء
                                @break
                            @case('died')
                                وفاة
                                @break
                            @case('confirmed')
                                مؤكدة
                                @break
                            @case('suspected')
                                اشتباه
                                @break
                        @endswitch
                    </td>
                    <td>هنا أيقونات</td>
                </tr>
            @endforeach 
        </table>
    </section>
    <section class="container">
        {{ $incidents->links() }}
    </section>
@endsection