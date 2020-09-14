@extends('layouts.app')

@section('content')

    @php
        if($incident->closed_at != null){
            $status = "closed";
        }elseif($incident->confirmed_at != null){
            $status = "confirmed";
        }else {
            $status = "suspected";
        }
    @endphp

    <section class="container covid-form-container" dir="rtl">
        <h1 class="covid-center">تحديث سجل الحالة</h1>
        <form action="/incident/{{$incident->id}}" method="POST" class="container">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for='person_name'>اسم صاحب الحالة</label>
                <input class="form-control" name="person_name" type="text" 
                    value="{{$incident->person_name}}"
                    minlength="5" maxlength="100"
                    @if(Auth::user()->id == 1) required @else readonly @endif>
                <small class="form-text text-muted">اكتب الاسم كما سيظهر في البرنامج. تأكد من عدم وجود شخص آخر باسم مشابه في مدرستك تجنبًا للالتباس.</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='person_id'>
                    رقم هوية صاحب الحالة
                </label>
                <input dir="ltr" class="form-control" name="person_id" type="text" 
                    placeholder="XXXXXXXXX" inputmode="numeric"
                    value="{{$incident->person_id}}"
                    minlength="9" maxlength="9"
                    pattern="^[0-9]+$"
                    required @if(Auth::user()->id != 1) readonly @endif>
                <small class="form-text text-muted">تأكد من إدخال قيمة صحيحة. أي خطأ في هذه القيمة سيسبب أخطاء في تتبع الحالات.</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
        </div>
            <div class="form-group">
                <label for='person_phone_primary'>رقم الهاتف</label>
                <input dir="ltr" class="form-control" name="person_phone_primary" type="tel"
                    inputmode="numeric" placeholder="02-XXX-XXXX" 
                    minlength="9" maxlength="15"
                    value="{{$incident->person_phone_primary}}"
                    pattern="^0[0-9\-x\.]+$"
                    required>
                <small class="form-text text-muted">أدخل رقم هاتف صاحب الحالة أو ولي أمره.</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='person_phone_secondary'>رقم هاتف إضافي</label>
                <input dir="ltr" class="form-control" name="person_phone_secondary" type="tel"
                    inputmode="numeric" placeholder="05X-XXX-XXXX" 
                    value="{{$incident->person_phone_secondary}}"
                    minlength="9" maxlength="15"
                    pattern="^0[0-9\-x\.]+$"
                    required>
                <small class="form-text text-muted">أدخل رقم هاتف إضافي لصاحب الحالة أو ولي أمره.</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label class="school-radio-label">نوع الحالة الآن: </label>
                @if($status == "suspected")
                    <div class="form-check form-check-inline covid-school-radio-grid">
                        <input class="form-check-input" type="radio" name="type" id="suspected" value="suspected" checked>
                        <label class="form-check-label" for="suspected"> اشتباه</label>
                    </div>
                @endif
                @if($status != "closed")
                    <div class="form-check form-check-inline covid-school-radio-grid">
                        <input class="form-check-input" type="radio" name="type" id="confirmed" value="confirmed"
                        @if($status == "confirmed") checked @endif>
                        <label class="form-check-label" for="confirmed"> حالة مؤكدة</label>
                    </div>
                @endif
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="type" id="closed" value="closed"
                    @if($status == "closed") checked disabled @endif>
                    <label class="form-check-label" for="closed">
                        مغلقة
                    </label>
                </div>
            </div>
            @if($status != "closed")
                <div class="form-group" id="closeType">
                    <h3>إذا كانت الحالة ستغلق، فحدد نوع الإغلاق: </h3>
                    <div class="form-check form-check-inline covid-school-radio-grid">
                        <input class="form-check-input" type="radio" name="close_type" id="falsepositive" value="falsepositive" 
                            @if($status == "suspected") checked 
                            @elseif( ($status == "closed") && ($incident->close_type == 1) ) checked
                            @endif>
                        <label class="form-check-label" for="falsepositive"> اشتباه خاطئ</label>
                    </div>
                    <div class="form-check form-check-inline covid-school-radio-grid">
                        <input class="form-check-input" type="radio" name="close_type" id="recovery" value="recovery"
                            @if($status == "confirmed") checked
                            @elseif( ($status == "closed") && ($incident->close_type == 2) ) checked
                            @endif>
                        <label class="form-check-label" for="recovery"> تعافي</label>
                    </div>
                    <div class="form-check form-check-inline covid-school-radio-grid">
                        <input class="form-check-input" type="radio" name="close_type" id="death" value="death"
                        @if( ($status == "closed") && ($incident->close_type == 3) ) checked @endif>
                        <label class="form-check-label" for="death"> وفاة</label>
                    </div>
                    <small class="form-text text-muted">إذا كان الاشتباه من جهة رسمية، فحدد الجهة في الملاحظات</small>
                </div>
                <div class="form-group" id="date">
                    <label for='date'>التاريخ</label>
                    <input dir="rtl" lang="ar" class="form-control" name="date" type="date"
                        value="{{date('Y-m-d')}}" min="2020-07-31" max="{{date('Y-m-d')}}"
                        required>
                    <small class="form-text text-muted">عدّل التاريخ حسب الحالة الجديدة إذا تغيرت الحالة.</small>
                    <div class="valid-tooltip">✓</div>
                    <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
                </div>
            @endif
            <div class="form-group">
                <h3>ملاحظات</h3>
                <small class="form-text text-muted">سجل أيّ ملاحظات أخرى هنا ...</small>
                <textarea class="form-control" name="notes" rows="4">
                    {{$incident->notes ?? ''}}
                </textarea>
            </div>
            <button class="btn btn-primary covid-form-button" type="submit">تسجيل الحالة</button>
        </form>
    </section>
@endsection