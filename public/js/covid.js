function deleter(theElement, message){
    swal({
        title: "هل أنت متأكد؟",
        text: message,
        type: "warning",
        buttons: [
            "لا تحذف",
            "نعم، احذف!"
        ],
        dangerMode: true
        })
    .then((status)=>{
        theElement.parentElement.submit()
    });
}

function undeleter(theElement, message){
    swal({
        title: "هل أنت متأكد؟",
        text: message,
        type: "warning",
        buttons: [
            "لا تسترجع",
            "نعم، استرجع!"
        ],
        dangerMode: false
        })
    .then((status)=>{
        theElement.parentElement.submit()
    });
}

function accountDisable(theElement, message){
    swal({
        title: "هل أنت متأكد؟",
        text: message,
        type: "warning",
        buttons: [
            "لا تعطّل",
            "نعم، عطّل الحساب!"
        ],
        dangerMode: true
        })
    .then((status)=>{
        theElement.parentElement.submit()
    });
}

function accountEnable(theElement, message){
    swal({
        title: "هل أنت متأكد؟",
        text: message,
        type: "warning",
        buttons: [
            "لا تفعِّل",
            "نعم، فعِّل الحساب!"
        ],
        dangerMode: true
        })
    .then((status)=>{
        theElement.parentElement.submit()
    });
}

function goTo(resource, num){
    window.location.href = window.location.protocol + '//' + window.location.host + '/' + resource + '/' + num;
    // console.log(window.location);
    // console.log(window.location.protocol + '//' + window.location.host + '/' + resource + '/' + num);
}

function goBack(){
    // window.location.href = document.referrer;
    window.history.back();
}