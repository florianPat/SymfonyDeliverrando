export function accordionToggler(elementId) {
    let elements = document.getElementsByClassName('accordionClass');
    for(let it of elements) {
        console.assert(it.hasAttribute('id'));
        if(it.getAttribute('id') === elementId) {
            if(it.style.display === 'none') {
                it.style.display = 'inline';
            } else {
                it.style.display = 'none';
            }
        } else if(it.style.display !== 'none') {
            it.style.display = 'none';
        }
    }
}

window.accordionToggler = accordionToggler;

(function() {
    let adminUsername = document.getElementById('inputUsername');
    if(adminUsername !== null) {
        if(adminUsername.getAttributeNode('value').nodeValue !== '') {
            accordionToggler('adminLogin');
            adminUsername.focus();
        } else {
            let customerUsernameLogin = document.getElementById('customer_login_email');
            if(customerUsernameLogin !== null) {
                if(customerUsernameLogin.getAttributeNode('value').nodeValue !== '') {
                    accordionToggler('personLogin');
                    customerUsernameLogin.focus();
                }
            }
        }
    }
})();