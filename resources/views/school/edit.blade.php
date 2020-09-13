@extends('layouts.app')

@section('content')
    <section class="container covid-form-container" dir="rtl">
        <h1 class="covid-center">تحديث ملف المدرسة</h1>
        <small class="text-danger">يرجى تحري الدقة في إدخال المعلومات، لأنها ضرورية لعمل الإحصاءات والتقارير الدورية.</small>
        <form action="/school/{{$school->id}}" method="POST" class="container">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for='name'>اسم المدرسة</label>
                <input class="form-control" name="name" type="text" 
                    placeholder="{{$school->user->name}}" 
                    @if(Auth::user()->id != 1) readonly @endif>
            </div>
            {{-- The following code is for future-proofing --}}
            {{-- It can be uncommented after allowing super-admin edits on school --}}
            {{--             
                <section class="container">
                    <h3 class="text-danger">كن حذرًا عند تعديل هذه المعلومات. أي خطأ قد يؤدي إلى منع الوصول.</h3>
                    @if(Auth::user()->id == 1)
                        <div class="form-group">
                            <label for='gov_id'>
                                رقم الهوية أو الرقم الوطني
                            </label>
                            <input dir="ltr" class="form-control" name="gov_id" type="text" 
                                value="{{$school->user->gov_id}}" inputmode="numeric"
                                minlength="9" maxlength="10"
                                pattern="^[0-9]+$">
                            <div class="valid-tooltip">✓</div>
                            <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
                        </div>
                        <div class="form-group">
                            <label for='email'>البريد الإلكتروني</label>
                            <input dir="ltr" class="form-control" name="email" type="email"
                                value="{{$user->email}}"
                                pattern="^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$"
                                minlength="10" maxlength="50">
                            <div class="valid-tooltip">✓</div>
                            <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
                        </div>
                        <div class="form-group">
                            <label for="directorate_id" placeholder="اختر مديرية ...">المديرية:</label>
                            <select class="form-control form-control-lg" id="directorate_id" name="directorate_id">
                                @foreach (App\Directorate::all() as $dir)
                                    <option value="{{$dir->id}}" 
                                        @if($dir->id == $user->directorate_id) selected @endif
                                        >
                                        {{$dir->name_ar}}
                                    </option>
                                @endforeach
                            </select> 
                        </div>
                    @endif
                </section>
             --}}
            <div class="form-group">
                <label for='phone_primary'>رقم الهاتف</label>
                <input dir="ltr" class="form-control" name="phone_primary" type="tel"
                    inputmode="numeric" value="{{$school->user->phone_primary}}" 
                    minlength="9" maxlength="15"
                    pattern="^0[0-9\-x\.]+$"
                    required>
                <small class="form-text text-muted">أدخل رقم الهاتف الرئيسي لصاحب الحساب</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='phone_secondary'>رقم هاتف إضافي</label>
                <input dir="ltr" class="form-control" name="phone_secondary" type="tel"
                    inputmode="numeric" value="{{$school->user->phone_secondary}}" 
                    minlength="9" maxlength="15"
                    pattern="^0[0-9\-x\.]+$"
                    required>
                <small class="form-text text-muted">أدخل رقم الهاتف الإضافي لصاحب الحساب</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='total_male_students'>عدد الطلاب الذكور</label>
                <input class="form-control" name="total_male_students" type="number" 
                    minlength="2" maxlength="3" inputmode="numeric"
                    pattern="^[0-9]+$" min="0" max="900"
                    value="{{$school->total_male_students}}"
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
                    value="{{$school->total_female_students}}"
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
                    value="{{$school->total_male_staff}}"
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
                    value="{{$school->total_female_staff}}"
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
                    value="{{$school->youngest_class}}"
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
                    value="{{$school->oldest_class}}"
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
                    value="{{$school->number_of_classrooms}}"
                    required>
                <small class="form-text text-muted">أدخل العدد الكلي (للشعب الصفية) في المدرسة، وليس عدد الصفوف أو الغرف. الصف الثالث أ والثالث ب هما شعبتان منفصلتان.</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label class="school-radio-label">ملكية البناء: </label>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="rented" id="rented_false" value=false
                        @if($school->rented == false) checked @endif>
                    <label class="form-check-label" for="rented_false"> ملك</label>
                </div>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="rented" id="rented_true" value=true
                        @if($school->rented == true) checked @endif>
                    <label class="form-check-label" for="rented_true"> مستأجرة</label>
                </div>
            </div>
            <div class="form-group">
                <label class="school-radio-label">فترة الدوام: </label>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="second_shift" id="second_shift_false" value="false" checked
                        @if($school->second_shift == false) checked @endif>
                    <label class="form-check-label" for="second_shift_false"> صباحي</label>
                </div>
                <div class="form-check form-check-inline covid-school-radio-grid">
                    <input class="form-check-input" type="radio" name="second_shift" id="second_shift_true" value="true"
                        @if($school->second_shift == true) checked @endif>
                    <label class="form-check-label" for="second_shift_true"> مسائي</label>
                </div>
            </div>
            <div class="form-group">
                <label for='building_year'>سنة البناء</label>
                <input class="form-control" name="building_year" type="number" 
                    minlength="4" maxlength="4" inputmode="numeric"
                    pattern="^[0-9]+$" min="1780" max="2020"
                    value="{{$school->building_year + 1780}}"
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
                    value="{{$school->head_of_school}}"
                    required>
                <small class="form-text text-muted">اكتب الاسم كما سيظهر في البرنامج. تأكد من كتابة الاسم الرباعي بطريقة صحيحة تجنبًا للالتباس.</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <button class="btn btn-warning covid-form-button" type="submit">تحديث معلومات الملف</button>
        </form>
    </section>
@endsection