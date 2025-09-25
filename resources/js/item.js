document.querySelectorAll('tr.clickable-row button').forEach(function(btn){
    btn.addEventListener('click', function(event){
        event.stopPropagation();
    });
});