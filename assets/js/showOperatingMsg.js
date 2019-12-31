(function ()
{
    let operationMsg = document.getElementById('operationMsg');
    if(operationMsg !== null) {
        setTimeout(() => operationMsg.style.display = 'none', 2000);
    }
})();