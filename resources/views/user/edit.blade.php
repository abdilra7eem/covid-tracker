@extends('layouts.app')

@section('content')
    <section class="container covid-form-container" dir="rtl">
        <h1 class="covid-center">تحديث معلومات حساب مستخدم</h1>
        <small class="form-text text-danger">لأسباب متعلقة بأمن المعلومات وموثوقيتها وتأمين الوصول، لا يُمكن تغيير عنوان البريد الإلكتروني ورقم الهوية/الرقم الوطني واسم صاحب الحساب إلّا عبر حساب واحد فقط من حسابات إدارة البرنامج.</small>
        <form action="/user/{{$user->id}}" method="POST" class="container">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for='name'>اسم صاحب الحساب</label>
                <input class="form-control" name="name" type="text" 
                    value="{{$user->name}}"
                    minlength="5" maxlength="100"
                    @if(Auth::user()->id != 1) disabled @endif>
                {{-- <small class="form-text text-muted">اكتب الاسم كما سيظهر في البرنامج. تأكد من عدم وجود حساب آخر باسم مشابه تجنبًا للالتباس.</small> --}}
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='gov_id'>
                    رقم الهوية أو الرقم الوطني
                </label>
                <input dir="ltr" class="form-control" name="gov_id" type="text" 
                    value="{{$user->gov_id}}" inputmode="numeric"
                    minlength="9" maxlength="10"
                    pattern="^[0-9]+$"
                    @if(Auth::user()->id != 1) disabled @endif>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
            </div>
            <div class="form-group">
                <label for='email'>البريد الإلكتروني</label>
                <input dir="ltr" class="form-control" name="email" type="email"
                    value="{{$user->email}}"
                    pattern="^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$"
                    minlength="10" maxlength="50"
                    @if(Auth::user()->id != 1) disabled @endif>
                <div class="valid-tooltip">✓</div>
                <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
                <div class="form-group">
                    <label for='phone_primary'>رقم الهاتف</label>
                    <input dir="ltr" class="form-control" name="phone_primary" type="tel"
                        inputmode="numeric" value="{{$user->phone_primary}}" 
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
                        inputmode="numeric" value="{{$user->phone_secondary}}" 
                        minlength="9" maxlength="15"
                        pattern="^0[0-9\-x\.]+$"
                        required>
                    <small class="form-text text-muted">أدخل رقم الهاتف الإضافي لصاحب الحساب</small>
                    <div class="valid-tooltip">✓</div>
                    <div class="invalid-tooltip">يرجى إدخال قيمة مناسبة</div>
                </div>
            </div>
            @if(Auth::user()->account_type == 1)
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
                    <small class="form-text text-muted">اختر اسم المديرية التي ينتهمي إليها الحساب الجديد. إذا لم تكن المديرية موجودة، فتواصل مع إدارة البرنامج.</small>
                </div>
            @endif
            <button class="btn btn-warning covid-form-button" type="submit">تحديث معلومات الحساب</button>
        </form>
    </section>
@endsection