@extends('layouts.app')

@section('content')
    <section class="container covid-form-container" dir="rtl">
        <h1 class="covid-center">إنشاء سجل إغلاق</h1>
        <small class="text-secondary">يرجى تحري الدقة في إدخال المعلومات، لأنها ضرورية لعمل الإحصاءات والتقارير الدورية.</small>
        <br/><br/>
        @if($current == 14)
            <small class="text-danger">
                المدرسة حالياً مغلقة مع تواجد الإدارة. 
                يمكنك إنشاء سجل إغلاق جديد إذا كانت المدرسة ستغلق بالكامل. 
                إذا كنت ترغب بتعديل سجل إغلاق، فلا تنشئ سجلًا جديدًا، 
                    بل اذهب إلى سجل الإغلاق ذي العلاقة، ثم اختر "تعديل".
            </small>
            <br/><br/>
        @endif
        @if($current == 13)
            <small class="text-danger">
                المدرسة حالياً مغلقة مع تواجد الإدارة والمعلمين. 
                يمكنك إنشاء سجل إغلاق جديد إذا كانت المدرسة ستغلق بالكامل 
                أو إذا كانت ستغلق مع عدم تواجد المعلمين
                إذا كنت ترغب بتعديل سجل إغلاق، فلا تنشئ سجلًا جديدًا، 
                بل اذهب إلى سجل الإغلاق ذي العلاقة، ثم اختر "تعديل".
            </small>
            <br/><br/>
        @endif
        @if($current < 13)
            <small class="text-danger">
                إذا كان سيتم إغلاق أكثر من شعبة، فقم بإنشاء سجل منفصل لكل شعبة سيجري إغلاقها.
            </small>
            <br/><br/>
        @endif


        <form action="/schoolClosure" method="POST" class="container">
            @csrf
            <div class="form-group">
                <label for='name'>اسم المدرسة</label>
                <input class="form-control" name="name" type="text" 
                    placeholder="{{$user->name}}" readonly>
            </div>
            <div class="form-group">
                <label for='closure_date'>تاريخ الإغلاق</label>
                <input class="form-control" name="closure_date" type="date" 
                    minlength="2" maxlength="3" inputmode="date"
                    min="2020-08-01" max="2021-07-31" value="{{date('Y-m-d')}}"
                    required>
                <small class="form-text text-muted">أدخل تاريخ يوم بدء الإغلاق الذي له هذا السجل</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <h3>نوع الإغلاق</h3>
                @if($current == 14)
                    <div class="form-check form-check-inline covid-school-radio-grid" style="width: 95%;">
                        <input class="form-check-input" type="radio" name="type" id="type" value="15" checked>
                        <label class="form-check-label" for="type" style="width: 85%;"> كامل مع عدم تواجد الإدارة</label>
                    </div>
                @else
                    <select name="type" id="type" class="form-control" required>
                        <option value="" disabled selected>اختر نوع الإغلاق ...</option>
                        <optgroup label="إغلاق كامل">
                            <option value="15">مع عدم تواجد الإدارة</option>
                            <option value="14">مع تواجد الإدارة فقط</option>
                        @if($current != 13)
                                <option value="13">مع تواجد الإدارة والمعلمين</option>
                            </optgroup>
                            <optgroup label="إغلاق جزئي">
                                <option value="1">إغلاق شعبة واحدة فقط</option>
                        @endif
                        </optgroup>
                    </select>
                @endif
            </div>

            @if($current < 13)
                <div class="form-group">
                    <h3>إذا اخترت إغلاق شعبة، فحدد الشعبة التي أُغلقَت أو سيجري إغلاقها: </h3>
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
                    <div class="form-group">
                        <label for='affected_students'>عدد الطلاب المتأثرين بهذا الإغلاق</label>
                        <input dir="ltr" class="form-control" name="affected_students" type="number"
                            inputmode="numeric" placeholder="35 مثلًا" 
                            minlength="1" maxlength="3" min="5" max="999"
                            pattern="^[0-9]+$">
                        {{-- <small class="form-text text-muted">العدد الكلي للطلاب المتأثرين بهذا الإغلاق، بما في ذلك المتأثرين بإغلاق آخر.</small>
                        <div class="valid-tooltip">✓</div>
                        <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div> --}}
                    </div>
                </div>
            @endif
            <button class="btn btn-primary covid-form-button" type="submit">إنشاء الملف</button>
        </form>
    </section>
@endsection