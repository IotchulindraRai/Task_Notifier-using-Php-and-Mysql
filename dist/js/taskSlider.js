const taskSlider = document.getElementById('taskSlider')
const taskItems = taskSlider.querySelectorAll('.reminders-item')
let tastSliderInterval;
const resizeSilder = () =>{
    var height = 0;
    taskItems.forEach(el=>{
        if(el.scrollHeight > height)
        height = el.scrollHeight;
    })
    taskSlider.querySelector('.reminders').style.height=`${height}px`;
}
const startSlider = () =>{
    tastSliderInterval = setInterval(()=>{
        var active = taskSlider.querySelector('.reminders-item.active')
        if(active.nextElementSibling == null)
            var nextEl =  taskItems[0];
        else
            var nextEl =  active.nextElementSibling;
            nextEl.style.transform = "translateX(100%)"
            setTimeout(()=>{
                active.classList.add('slideLeftTrans')
                nextEl.classList.add('slideLeftTrans')
                active.classList.remove('active')
                nextEl.classList.add('active')
                setTimeout(()=>{
                    nextEl.removeAttribute('style')
                    active.classList.remove('slideLeftTrans')
                    nextEl.classList.remove('slideLeftTrans')
                },1000)
            }, 100)

    },10000)
}

window.onload = function(){
    startSlider()
    resizeSilder()
}
window.onresize = function(){
    resizeSilder()
}