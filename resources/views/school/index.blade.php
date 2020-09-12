@extends('layouts.app')

@section('content')
    <section class="container">
        @if(Auth::user()->school == null)
            <a href="/school/create" class="btn btn-success covid-form-button">إنشاء سجل إغلاق جديد</a>
            <br/>
        @endif
        <table class="table table-hover text-right">
            <tr>
                <th scope="col">#</th>
                <th scope="col">رقم الحساب</th>
                <th scope="col">الرقم الوطني</th>
                <th scope="col">الاسم</th>
                <th scope="col">Email</th>
                <th scope="col">الهاتف الرئيسي</th>
                {{-- <th scope="col">الهاتف الثاني</th> --}}
                <th scope="col">اسم مدير المدرسة</th>

                {{-- <th scope="col">الملكية</th> --}}
                <th scope="col">الدوام</th>
                {{-- <th scope="col">سنة البناء</th> --}}
                {{-- <th scope="col">عمر البناء</th> --}}
            </tr>
            @foreach($schools as $school)
                <tr class="
                    @if($school->active == false) table-secondary @endif
                    @if(!isset($school->school['user_id'])) table-danger @endif
                    covid-index-row"
                    @if(($school->school == null) || ($school->school['id'] == null))
                        onclick="goTo('user', {{$school->id}})"
                    @else
                        onclick="goTo('school', {{$school->school['id']}})"
                    @endif
                >
                    <td>{{$school->school['id']}}</td>
                    <td>{{$school->id}}</td>
                    <td>{{$school->gov_id}}</td>
                    <td>{{$school->name}}</td>
                    <td dir="ltr">{{$school->email}}</td>
                    <td dir="ltr">{{$school->phone_primary}}</td>
                    {{-- <td>{{$school->phone_secondary}}</td> --}}
                    <td>
                        @if(isset($school->school['head_of_school']))
                            {{$school->school['head_of_school']}}
                        @endif
                    </td>
                    {{-- <td>
                        @if(isset($school->school['rented']))
                            @if($school->school['rented'] == true) إيجار
                            @else ملك @endif
                        @endif
                    </td> --}}
                    <td>
                        @if(isset($school->school['second_shift']))
                            @if($school->school['second_shift'] == true) مسائي
                            @else صباحي @endif
                        @endif
                    </td>
                    {{-- <td>
                        @if(isset($school->school['building_year']))
                            {{$school->school['building_year'] + 1780}}
                        @endif
                    </td>
                    <td>
                        @if(isset($school->school['building_year']))
                            {{ 241 - $school->school['building_year']}}
                        @endif
                    </td> --}}
            @endforeach 
        </table>
    </section>
    <section class="container">
        {{ $schools->links() }}
    </section>
@endsection