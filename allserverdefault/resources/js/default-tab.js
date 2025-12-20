document.addEventListener('DOMContentLoaded', function() {
    const firstVisit = sessionStorage.getItem('pelican_servers_first_visit');
    
    if (!firstVisit) {
        sessionStorage.setItem('pelican_servers_first_visit', 'true');
        
        setTimeout(() => {
            const allServersButton = document.querySelector('button[wire\\:click*="activeTab"][wire\\:click*="all"]');
            if (allServersButton && !allServersButton.classList.contains('fi-active')) {
                allServersButton.click();
            }
        }, 100);
    }
});

const observer = new MutationObserver((mutations) => {
    const firstVisit = sessionStorage.getItem('pelican_servers_first_visit');
    
    if (!firstVisit) {
        const allServersButton = document.querySelector('button[wire\\:click*="activeTab"][wire\\:click*="all"]');
        if (allServersButton && !allServersButton.classList.contains('fi-active')) {
            allServersButton.click();
            sessionStorage.setItem('pelican_servers_first_visit', 'true');
            observer.disconnect();
        }
    }
});

if (document.body) {
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
}
