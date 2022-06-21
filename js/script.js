let h3 = document.querySelector('.static_data h3');
let p = document.querySelector('.static_data p');
var x = document.getElementById("myVideo");
var x_2 = document.getElementById("myVideo_2");
let controller = 2;
let controller_2 = 2;
let toggleData = document.querySelector('nav svg');
let data = document.querySelector('.toggle-data');
toggleData.addEventListener('click', () => {
    data.classList.toggle('block')
})
function control() {
    controller % 2 == 0 ? playVid(x, '.video') : pauseVid();
    controller++;
}
function control2() {
    controller_2 % 2 == 0 ? playVid(x_2, '.video_2') : pauseVid();
    controller_2++;
}

function playVid(vid,vid_class) {
    vid.play();
    document.querySelector(vid_class).style.display = 'none';
}

function pauseVid() {
    vid.pause();
}


function controlContent(a) {
    let attr = a.getAttribute("data-name");
    let loop = document.querySelectorAll('.controler div');

    for (let i = 0; i < loop.length; i++) {
        loop[i].style.borderBottom = "none"
    }
    a.style.borderBottom = "3px solid #0c9890"
    changeContent(attr);
}

function changeContent(item) {
    if (item == "patient") {
        h3.innerText = `يمكنك التاكد من نتائج التحاليل والاشاعات ومعرفة النتيجة فى الحال`
        p.innerText = `ان covid - 19 _diagnosis تعد من اولى المنصات فى هذا المجال فهي تعمل على مساعدة المرضى فى الحصول علي نتائج التحاليل والاشعه الخاصة بهم من خلال الذكاء الاصطناعي مما يسهل علي الطبيب المعالج اتخاذ القرارات اللازمة بشان المريض مما يخفف العبئ علي الاطباء نظرا
        لتزايد عدد الحالات المصابة بفيرس كرونا فى الاونة الاخيرة فكان هدفنا الاساسي العمل علي تجنب التزاحم.فبعد ان يقوم البرنامج بالتاكد من النتائج يتم تحويل النتائج الى الطبيب المعالج وذلك فى حالة ثبوت الاصابة لاتخاذ الاجراءات اللازمة
        وكتابة الادوية المناسبة للمريض.`
    } else if (item == "doctor") {
        h3.innerText = `الجزء الخاص بالاطباء هو الجانب المسئول عن اتخاذ الاجراءات بشان المرضى `
        p.innerText = `ان الاطباء هم الجانب الاكبر فى هذا المشروع 
         حيث انهم يعملون علي التاكد من حالة المرضى والتاكد من كتابة التقارير اللازمة لكل منهم ولهم صلاحية الوصول لبيانات المرضى الموكلة اليهم للنظر فى التقارير ومراجعة البيانات الخاصة بحالتهم المرضية 
         وذلك للتاكد من حالة المريض ووصف الدواء المناسب لكل مريض وذلك من اجل الحرص علي التخلص من فيروس كرونا فى اسرع وقت ممكن وايضا لضمان سلامة الجميع.`
    } else if (item == 'supervisor') {
        h3.textContent = `يوجد مشروفون موكل اليهم اضافة الحالات الى اطباء مخصصون للنظر فى التقارير الخاص بهم `
        p.textContent = `ان مهام المشرف هي التاكد من وصول جميع التقارير بشكل صحيح الى الاطباء والتاكد من ان جميع العمليات تسير بشكل صحيح وانة لاتوجد اي اخطاء فى الوصول الى الاطباء وانه يوجد لكل حالة طبيب وان النتيجة الخاص بة قد ظهرت بالفعل من خلال الفحص وانها قد تم مراجعتها من قبل الطبيب وذلك للحرص علي تقديم خدمة كاملة بدون اي اخطاء او كسور `
    }
}