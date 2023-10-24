const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry)=>{
        if(entry.isIntersecting){
            entry.target.classList.add('show');
        }
        else{
            entry.target.classList.remove('show');
        }
    });
});

const hiddenElements = document.querySelectorAll('.hidden');
hiddenElements.forEach((el) => observer.observe(el));

const observer2 = new IntersectionObserver((entries) => {
    entries.forEach((entry)=>{
        if(entry.isIntersecting){
            entry.target.classList.add('show');
        }
        else{
            entry.target.classList.remove('show');
        }
    });
});

const hiddenElements2 = document.querySelectorAll('.hidden2');
hiddenElements2.forEach((el) => observer2.observe(el));

const floatingDiv = document.getElementById('cursor-follower');

// Add an event listener to the document to track mouse movement
document.addEventListener('mousemove', (e) => {
    // Update the position of the floating div to follow the cursor
    floatingDiv.style.left = (e.clientX + 10) + 'px';  // Add 10 pixels to adjust position
    floatingDiv.style.top = (e.clientY + 10) + 'px';   // Add 10 pixels to adjust position
});