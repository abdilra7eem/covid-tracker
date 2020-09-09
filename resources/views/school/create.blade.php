@extends('layouts.app')

@section('content')
    <section class="container covid-form-container" dir="rtl">
        <h1 class="covid-center">إنشاء ملف المدرسة</h1>
        <small class="text-danger">يرجى تحري الدقة في إدخال المعلومات، لأنها ضرورية لعمل الإحصاءات والتقارير الدورية.</small>
        <form action="/school" method="POST" class="container">
            @csrf
            <div class="form-group">
                <label for='name'>اسم المدرسة</label>
                <input class="form-control" name="name" type="text" 
                    placeholder="{{$user->name}}" readonly>
            </div>
            <div class="form-group">
                <label for='total_male_students'>عدد الطلاب الذكور</label>
                <input class="form-control" name="total_male_students" type="number" 
                    minlength="2" maxlength="3" inputmode="numeric"
                    pattern="^[0-9]+$" min="0" max="900"
                    required>
                <small class="form-text text-muted">اكتب عدد الطلاب الذكور فقط بالأرقام. إذا كان العدد صفرًا، فاكتب 0</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='total_female_students'>عدد الطالبات الإناث</label>
                <input class="form-control" name="total_female_students" type="number" 
                    minlength="2" maxlength="3" inputmode="numeric"
                    pattern="^[0-9]+$" min="0" max="900"
                    required>
                <small class="form-text text-muted">اكتب عدد الطالبات الإناث فقط بالأرقام. إذا كان العدد صفرًا، فاكتب 0</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='total_male_staff'>عدد الموظفين الذكور</label>
                <input class="form-control" name="total_male_staff" type="number" 
                    minlength="1" maxlength="2" inputmode="numeric"
                    pattern="^[0-9]+$" min="0" max="40"
                    required>
                <small class="form-text text-muted">اكتب عدد الموظفين الذكور فقط بالأرقام. إذا كان العدد صفرًا، فاكتب 0</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='total_female_staff'>عدد الموظفات الإناث</label>
                <input class="form-control" name="total_female_staff" type="number" 
                    minlength="2" maxlength="3" inputmode="numeric"
                    pattern="^[0-9]+$" min="0" max="40"
                    required>
                <small class="form-text text-muted">اكتب عدد الموظفات الإناث فقط بالأرقام. إذا كان العدد صفرًا، فاكتب 0</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='youngest_class'>أصغر صف في المدرسة (بالأرقام)</label>
                <input class="form-control" name="youngest_class" type="number" 
                    minlength="1" maxlength="2" inputmode="numeric"
                    pattern="^[0-9]+$" min="1" max="12"
                    required>
                <small class="form-text text-muted">أدخل الرقم الذي يعبر عن مستوى الصف. اكتب 5 للصف الخامس، أو 1 للصف الأول، وهكذا</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='oldest_class'>أكبر صف في المدرسة (بالأرقام)</label>
                <input class="form-control" name="oldest_class" type="number" 
                    minlength="1" maxlength="2" inputmode="numeric"
                    pattern="^[0-9]+$" min="1" max="12"
                    required>
                <small class="form-text text-muted">أدخل الرقم الذي يعبر عن مستوى الصف. اكتب 6 للصف السادس، أو 11 للصف الحادي عشر وهكذا</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='number_of_classrooms'>عدد الشعب الصفية في المدرسة</label>
                <input class="form-control" name="number_of_classrooms" type="number" 
                    minlength="1" maxlength="2" inputmode="numeric"
                    pattern="^[0-9]+$" min="3" max="50"
                    required>
                <small class="form-text text-muted">أدخل العدد الكلي (للشعب الصفية) في المدرسة، وليس عدد الصفوف أو الغرف. الصف الثالث أ والثالث ب هما شعبتان منفصلتان.</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label class="school-radio-label">ملكية البناء: </label>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="rented" id="rented_false" value=false checked>
                    <label class="form-check-label" for="rented_false"> ملك</label>
                </div>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="rented" id="rented_true" value=true>
                    <label class="form-check-label" for="rented_true"> مستأجرة</label>
                </div>
            </div>
            <div class="form-group">
                <label class="school-radio-label">فترة الدوام: </label>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="second_shift" id="second_shift_false" value="false" checked>
                    <label class="form-check-label" for="second_shift_false"> صباحي</label>
                </div>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="second_shift" id="second_shift_true" value="true">
                    <label class="form-check-label" for="second_shift_true"> مسائي</label>
                </div>
            </div>
            <div class="form-group">
                <label for='building_year'>سنة البناء</label>
                <input class="form-control" name="building_year" type="number" 
                    minlength="4" maxlength="4" inputmode="numeric"
                    pattern="^[0-9]+$" min="1780" max="2020"
                    required>
                <small class="form-text text-muted">السنة التي تأسس فيها البناء الحالي للمدرسة (أربع خانات رقمية).</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='head_of_school'>اسم مدير المدرسة</label>
                <input class="form-control" name="head_of_school" type="text" 
                    placeholder="أحمد محمد أحمد محمد" 
                    minlength="5" maxlength="100"
                    required>
                <small class="form-text text-muted">اكتب الاسم كما سيظهر في البرنامج. تأكد من كتابة الاسم الرباعي بطريقة صحيحة تجنبًا للالتباس.</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <button class="btn btn-primary covid-form-button" type="submit">إنشاء الملف</button>
        </form>
    </section>
@endsection