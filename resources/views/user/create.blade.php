@extends('layouts.app')

@section('content')
    <section class="container covid-form-container" dir="rtl">
        <h1 class="covid-center">إنشاء حساب مستخدم جديد</h1>
        @if(Auth::user()->account_type == 2)
            <small class="text-danger">يمكنك فقط إنشاء حسابات من نوع "مدرسة" في مديريتك. لإنشاء حساب مشرف، تواصل مع إدارة البرنامج. معلومات المديرية ستؤخد تلقائيًا من معلومات حسابك.</small>
        @endif
        @if(Auth::user()->account_type == 1)
            <small class="text-danger">يمكنك إنشاء حسابات من نوع "مشرف" فقط. لإنشاء حساب مدرسة تواصل مع أحد المشرفين</small>
        @endif
        <form action="/user" method="POST" class="container">
            @csrf
            <div class="form-group">
                <label for='name'>اسم صاحب الحساب</label>
                <input class="form-control" name="name" type="text" 
                    @if(Auth::user()->account_type == 2)
                        placeholder="مدرسة ابن رشد الأساسية للبنين" 
                    @else placeholder="أحمد محمد أحمد محمد" 
                    @endif
                    minlength="5" maxlength="100"
                    required>
                <small class="form-text text-muted">اكتب الاسم كما سيظهر في البرنامج. تأكد من عدم وجود حساب آخر باسم مشابه تجنبًا للالتباس.</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='gov_id'>
                    @if(Auth::user()->account_type == 2) الرقم الوطني
                    @else رقم الهوية
                    @endif
                </label>
                <input dir="ltr" class="form-control" name="gov_id" type="text" 
                    placeholder="XXXXXXXXX" inputmode="numeric"
                    minlength="9" maxlength="10"
                    pattern="^[0-9]+$"
                    required>
                <small class="form-text text-muted">أدخل رقمًا صحيحًا. لن يُقبل رقم غير مناسب أو مكرر.</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='email'>البريد الإلكتروني</label>
                <input dir="ltr" class="form-control" name="email" type="email"
                    placeholder="good_email@example.com" 
                    pattern="^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$"
                    minlength="10" maxlength="50"
                    required>
                <small class="form-text text-muted">عنوان البريد الإلكتروني الرسمي</small>
                <small class="form-text text-danger">تأكد جيدًا من عنوان البريد الإلكتروني قبل إنشاء الحساب. لا يمكن تغييره لاحقًا لأسباب تتعلق بأمن معلومات الحساب.</small>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
                <div class="form-group">
                    <label for='phone_primary'>رقم الهاتف</label>
                    <input dir="ltr" class="form-control" name="phone_primary" type="tel"
                        inputmode="numeric" placeholder="02-XXX-XXXX" 
                        minlength="9" maxlength="15"
                        pattern="^0[0-9\-x\.]+$"
                        required>
                    <small class="form-text text-muted">أدخل رقم الهاتف الأرضي الرسمي للمديرية شاملاً مقدمة المدينة</small>
                    <div class="valid-tooltip">✓</div>
                    <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
                </div>
                <div class="form-group">
                    <label for='phone_secondary'>رقم هاتف إضافي</label>
                    <input dir="ltr" class="form-control" name="phone_secondary" type="tel"
                        inputmode="numeric" placeholder="05X-XXX-XXXX" 
                        minlength="9" maxlength="15"
                        pattern="^0[0-9\-x\.]+$"
                        required>
                    <small class="form-text text-muted">أدخل رقم الهاتف الأرضي الرسمي للمديرية شاملاً مقدمة المدينة</small>
                    <div class="valid-tooltip">✓</div>
                    <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
                </div>
            </div>
            @if(Auth::user()->account_type == 1)
                <div class="form-group">
                    <label for="directorate_id" placeholder="اختر مديرية ...">المديرية:</label>
                    <select class="form-control form-control-lg" id="directorate_id" name="directorate_id">
                        @foreach (App\Directorate::all() as $dir)
                            <option value="{{$dir->id}}">{{$dir->name_ar}}</option>
                        @endforeach
                    </select> 
                    <small class="form-text text-muted">اختر اسم المديرية التي ينتهمي إليها الحساب الجديد. إذا لم تكن المديرية موجودة، فتواصل مع إدارة البرنامج.</small>
                </div>
            @endif
            <button class="btn btn-primary covid-form-button" type="submit">إنشاء الحساب</button>
        </form>
    </section>
@endsection