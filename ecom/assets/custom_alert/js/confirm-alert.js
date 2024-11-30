// script.js

function showConfirm(message, onConfirm, onCancel) {
    const confirmContainer = document.getElementById('confirm-container');
    confirmContainer.innerHTML = '';

    const confirmDialog = document.createElement('div');
    confirmDialog.className = 'confirm-dialog';

    const icon = document.createElement('div');
    icon.className = 'confirm-icon';
    icon.innerHTML = '&#9888;'; // Warning sign icon

    const confirmMessage = document.createElement('div');
    confirmMessage.className = 'confirm-message';
    confirmMessage.textContent = message;

    const confirmButtons = document.createElement('div');
    confirmButtons.className = 'confirm-buttons';

    const confirmButton = document.createElement('button');
    confirmButton.className = 'confirm-button';
    confirmButton.textContent = 'Confirm';
    confirmButton.onclick = () => {
        if (onConfirm) onConfirm();
        hideConfirm();
    };

    const cancelButton = document.createElement('button');
    cancelButton.className = 'cancel-button';
    cancelButton.textContent = 'Cancel';
    cancelButton.onclick = () => {
        if (onCancel) onCancel();
        hideConfirm();
    };

    confirmButtons.appendChild(confirmButton);
    confirmButtons.appendChild(cancelButton);

    confirmDialog.appendChild(icon);
    confirmDialog.appendChild(confirmMessage);
    confirmDialog.appendChild(confirmButtons);

    confirmContainer.appendChild(confirmDialog);
    confirmContainer.style.display = 'flex';
}

function hideConfirm() {
    const confirmContainer = document.getElementById('confirm-container');
    confirmContainer.style.display = 'none';
}
