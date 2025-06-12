
var sidebarlinks = document.querySelectorAll('.sidebar-link');

sidebarlinks.forEach((link) => {
    link.addEventListener('click',function () {
        this.classList.toggle('active');
    });
});

document.addEventListener('DOMContentLoaded', function (){
    var elements = document.querySelectorAll('.nav-icon');
    
    elements.forEach((ele) => {
        ele.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            var dropdown = this.closest('.dropdown').querySelector('.dropdown-menu');

            document.querySelectorAll('.dropdown-menu').forEach((menu) => {
                if (menu != dropdown) {
                    menu.classList.remove('show');
                }
            });
            dropdown.classList.toggle('show');
        });
    });
});



