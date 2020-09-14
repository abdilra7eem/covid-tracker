@extends('layouts.app')

@section('content')
    <section class="container covid-form-container" dir="rtl">
        <h1 class="covid-center">تحديث سجل الإغلاق</h1>
        <small class="text-secondary">يرجى تحري الدقة في إدخال المعلومات، لأنها ضرورية لعمل الإحصاءات والتقارير الدورية.</small>
        <br/><br/>
        <form action="/schoolClosure/{{$closure->id}}" method="POST" class="container">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for='name'>اسم المدرسة</label>
                <input class="form-control" name="name" type="text" 
                    placeholder="{{Auth::user()->name}}" readonly>
            </div>
            <table class="table table-hover text-right table-striped">
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
                @if($closure->reopening_date != null)
                    <tr>
                        <td scope="row">الحالة</td>
                        <td>
                            أعيد فتح المدرسة في {{$closure->reopening_date}}. 
                            <span class="text-danger">
                                يمكنك فقط تحديث الملاحظات
                            </span>
                        </td>
                    </tr>
                @endif
            </table>
            @if($closure->reopening_date != null)
                <div class="form-group">
                    <input type="checkbox" class="form-check-input" id="reopening">
                    <label class="form-check-label" for="reopening">إنهاء الإغلاق الذي له هذا السجل</label>
                </div>            
                <div class="form-group">
                    <label for='reopening_date'>تاريخ انتهاء الإغلاق</label>
                    <input class="form-control" name="reopening_date" type="date" 
                        minlength="2" maxlength="3" inputmode="date"
                        min="2020-08-01" max="2021-07-31" value="{{date('Y-m-d')}}"
                        required>
                    <small class="form-text text-muted">إذا اخترت إنهاء الإغلاق، فأدخل تاريخ  انتهاء الإغلاق الذي له هذا السجل</small>
                    <div class="valid-tooltip">✓</div>
                    <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
                </div>
            @endif
            <div class="form-group">
                <h3>ملاحظات</h3>
                <small class="form-text text-muted">سجل أيّ ملاحظات أخرى هنا ...</small>
                <textarea class="form-control" name="notes" rows="4">
                    {{$closure->notes ?? ''}}
                </textarea>
            </div>
            <button class="btn btn-primary covid-form-button" type="submit">إنشاء الملف</button>
        </form>
    </section>
@endsection