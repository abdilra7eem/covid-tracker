<!doctype html>
<html lang="ar" dir="rtl" style="text-align: right">
@include('includes.head')
<body style="text-align: start;">
    <div id="app">
        @include('includes.navbar')

        <main class="py-4" dir="rtl" lang="ar">
            @include('includes.messages')
            @yield('content')
        </main>
    </div>
</body>
</html>
