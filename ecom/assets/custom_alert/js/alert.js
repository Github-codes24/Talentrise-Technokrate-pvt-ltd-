// script.js

function showAlert(message, type) {
    const alertContainer = document.getElementById('alert-container');

    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;

    const icon = document.createElement('span');
    icon.className = 'alert-icon';
    
    switch(type) {
        case 'success':
            icon.innerHTML = '&#10004;'; // Checkmark
            break;
        case 'error':
            icon.innerHTML = '&#10060;'; // Cross mark
            break;
        case 'warning':
            icon.innerHTML = '&#9888;'; // Warning sign
            break;
        case 'info':
            icon.innerHTML = '&#8505;'; // Information sign
            break;
    }

    const messageSpan = document.createElement('span');
    messageSpan.textContent = message;

    const progressBar = document.createElement('div');
    progressBar.className = 'progress-bar';
    
    const progressBarFill = document.createElement('div');
    progressBarFill.className = 'progress-bar-fill';
    progressBar.appendChild(progressBarFill);

    alertDiv.appendChild(icon);
    alertDiv.appendChild(messageSpan);
    alertDiv.appendChild(progressBar);

    alertContainer.appendChild(alertDiv);

    setTimeout(() => {
        alertDiv.remove();
    }, 5000); // Adjust the duration as needed
}

