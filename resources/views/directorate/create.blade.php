@extends('layouts.app')

@section('content')
    <section class="container covid-form-container" dir="rtl">
        <h1 class="covid-center">إنشاء ملف مديرية</h1>
        <form action="/directorate" method="POST" class="container">
            @csrf
            <div class="form-group">
                <label for='name'>معرّف المديرية</label>
                <input dir="ltr" class="form-control" name="name" type="text" 
                    pattern="^[a-zA-Z1-9]+$" placeholder="ramallah مثلًا" 
                    minlength="3" maxlength="15"
                    required>
                <small class="form-text text-muted">اسم المديرية باللغة الإنجليزية بحروف صغيرة وبدون فراغات</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='name_ar'>اسم المديرية بالعربية</label>
                <input class="form-control" name="name_ar" type="text" 
                    placeholder="رام الله" 
                    minlength="3" maxlength="15"
                    required>
                <small class="form-text text-muted">اكتب اسم المديرية كما ترغب أن يظهر للمستخدمين</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='email'>البريد الإلكتروني</label>
                <input dir="ltr" class="form-control" name="email" type="email"
                    placeholder="directorate_email@example.com" 
                    pattern="^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$"
                    minlength="10" maxlength="50"
                    required>
                <small class="form-text text-muted">عنوان البريد الإلكتروني الرسمي للمديرية</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='phone_number'>رقم هاتف المديرية</label>
                <input dir="ltr" class="form-control" name="phone_number" type="tel"
                    inputmode="numeric" placeholder="02-XXX-XXXX" 
                    minlength="9" maxlength="15"
                    pattern="^0[0-9\-x\.]+$"
                    required>
                <small class="form-text text-muted">أدخل رقم الهاتف الأرضي الرسمي للمديرية شاملاً مقدمة المدينة</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='head_of_directorate'>اسم المدير العام للمديرية</label>
                <input class="form-control" name="head_of_directorate" type="text" 
                    placeholder="اكتب الاسم هنا" 
                    required>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='school_count'>عدد مدارس المديرية (بالأرقام)</label>
                <input class="form-control" name="school_count" type="number"
                    inputmode="numeric" placeholder="مثلا: 120" 
                    minlength="2" maxlength="3"
                    required>
                <small class="form-text text-muted">تستخدم للإحصاءات الشهرية والتراكمية</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <button class="btn btn-primary covid-form-button" type="submit">إنشاء الملف</button>
        </form>
    </section>
@endsection