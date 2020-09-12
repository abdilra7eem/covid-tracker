@extends('layouts.app')

@section('content')
    <section class="container covid-form-container" dir="rtl">
        <h1 class="covid-center">إنشاء سجل حالة جديد</h1>
            <small class="text-danger">
                استخدم هذا النموذج لتسجيل الحالات التي في مدرستك فقط. 
                لا تستخدمه لتسجيل حالات في مدارس أو أماكل أخرى.
            </small>
            <small class="text-danger">
                يمكنك استخدام هذا النموذج لتسجيل حالة جديدة فقط. 
            </small>
            <small class="text-danger">
                إذا كانت لديك حالة مسجلة مسبقًا لم يتم إغلاقُها، 
                فيرجى الذهاب إلى ملف الحالة واختيار "تعديل".
            </small>
            <small class="text-danger">
                إذا كانت لديك حالة سابقة لنفس الشخص تم إغلاقها، 
                فتُرجى تعبئة هذا النموذج. 
                سيتعرف البرنامج تلقائيًا على الحالات المكررة.
            </small>
        <form action="/incident" method="POST" class="container">
            @csrf
            <div class="form-group">
                <label for='person_name'>اسم صاحب الحالة</label>
                <input class="form-control" name="person_name" type="text" 
                    placeholder="أحمد محمد أحمد محمد" 
                    minlength="5" maxlength="100"
                    required>
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
                    minlength="9" maxlength="10"
                    pattern="^[0-9]+$"
                    required>
                <small class="form-text text-muted">تأكد من إدخال قيمة صحيحة. أي خطأ في هذه القيمة سيسبب أخطاء في تتبع الحالات.</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
        </div>
            <div class="form-group">
                <label for='person_phone_primary'>رقم الهاتف</label>
                <input dir="ltr" class="form-control" name="person_phone_primary" type="tel"
                    inputmode="numeric" placeholder="02-XXX-XXXX" 
                    minlength="9" maxlength="15"
                    pattern="^0[0-9()- ]+$"
                    required>
                <small class="form-text text-muted">أدخل رقم هاتف صاحب الحالة أو ولي أمره.</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='person_phone_secondary'>رقم هاتف إضافي</label>
                <input dir="ltr" class="form-control" name="person_phone_secondary" type="tel"
                    inputmode="numeric" placeholder="05X-XXX-XXXX" 
                    minlength="9" maxlength="10"
                    pattern="^0[0-9()- ]+$"
                    required>
                <small class="form-text text-muted">أدخل رقم هاتف إضافي لصاحب الحالة أو ولي أمره.</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label class="school-radio-label">الجنس: </label>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="sex" id="sex_male" value="male" checked>
                    <label class="form-check-label" for="sex_male"> ذكر</label>
                </div>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="sex" id="sex_female" value="female">
                    <label class="form-check-label" for="sex_female"> أنثى</label>
                </div>
            </div>
            <div class="form-group">
                <label class="school-radio-label">وظيفة صاحب الحالة: </label><br/>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="job" id="job_student" value="student" checked>
                    <label class="form-check-label" for="job_student"> طالب</label>
                </div>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="job" id="job_teacher" value="teacher">
                    <label class="form-check-label" for="job_teacher"> معلم</label>
                </div>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="job" id="job_admin" value="admin">
                    <label class="form-check-label" for="job_admin"> إداري</label>
                </div>
            </div>
            <div class="form-group">
                <label class="school-radio-label">نوع الحالة: </label>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="type" id="suspected" value="suspected" checked>
                    <label class="form-check-label" for="suspected"> اشتباه</label>
                </div>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="type" id="confirmed" value="confirmed">
                    <label class="form-check-label" for="confirmed"> حالة مؤكدة</label>
                </div>
            </div>
            <div class="form-group">
                <h3>إذا كانت الحالة اشتباه، فحدد نوع الاشتباه: </h3>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="suspect_type" id="personal" value="personal" checked>
                    <label class="form-check-label" for="personal"> شخصي/ولي أمر</label>
                </div>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="suspect_type" id="doc" value="doc">
                    <label class="form-check-label" for="doc"> طبيب خاص</label>
                </div>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="suspect_type" id="gov" value="gov">
                    <label class="form-check-label" for="gov"> جهة رسمية</label>
                </div>
                <small class="form-text text-muted">إذا كان الاشتباه من جهة رسمية، فحدد الجهة في الملاحظات</small>
            </div>
            <div class="form-group">
                <label for='date'>التاريخ</label>
                <input dir="rtl" lang="ar" class="form-control" name="date" type="date"
                    value="{{date('Y-m-d')}}" min="2020-07-31" max="{{date('Y-m-d')}}"
                    required>
                <small class="form-text text-muted">أدخل تاريخ الاشتباه أو تسجيل الحالة.</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <h3>إذا كان صاحب الحالة طالبًا: </h3>
                <div class="form-group">
                    <label for='grade'>الصف (بالأرقام)</label>
                    <input dir="ltr" class="form-control" name="grade" type="number"
                        inputmode="numeric" placeholder="11 مثلًا" 
                        minlength="1" maxlength="2" min="1" max="12"
                        pattern="^[0-9]+$">
                    {{-- <small class="form-text text-muted">أدخل رقم هاتف إضافي لصاحب الحالة أو ولي أمره.</small>
                    <div class="valid-tooltip">✓</div>
                    <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div> --}}
                </div>
                <div class="form-group">
                    <label for='grade_section'>رقم الشعبة</label>
                    <input dir="ltr" class="form-control" name="grade_section" type="number"
                        inputmode="numeric" placeholder="1 مثلًا" 
                        minlength="1" maxlength="2" min="1" max="15"
                        pattern="^[0-9]+$">
                    {{-- <small class="form-text text-muted">أدخل رقم هاتف إضافي لصاحب الحالة أو ولي أمره.</small>
                    <div class="valid-tooltip">✓</div>
                    <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div> --}}
                </div>
            </div>
            <div class="form-group">
                <h3>ملاحظات</h3>
                <small class="form-text text-muted">سجل أيّ ملاحظات أخرى هنا ...</small>
                <textarea class="form-control" name="notes" rows="4"></textarea>
                {{-- <small class="form-text text-muted">أدخل رقم هاتف إضافي لصاحب الحالة أو ولي أمره.</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div> --}}
            </div>
            <button class="btn btn-primary covid-form-button" type="submit">تسجيل الحالة</button>
        </form>
    </section>
@endsection