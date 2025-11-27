
function openCustomPopup() {
    document.getElementById('custom-popup-arp').style.display = 'block';
}

// Minimize the custom-popup
function minimizePopup() {
    document.getElementById('custom-popup-arp').style.display = 'none';
}

// Maximize the custom-popup
function maximize() {
    const customPopup = document.getElementById('custom-popup-arp');
    if (customPopup.style.width === '100%' && customPopup.style.height === '100%') {
        customPopup.style.width = '50%';
        customPopup.style.height = 'auto';
        customPopup.style.left = '50%';
        customPopup.style.top = '50%';
        customPopup.style.transform = 'translate(-50%, -50%)';
    } else {
        customPopup.style.width = '100%';
        customPopup.style.height = '100%';
        customPopup.style.left = '0';
        customPopup.style.top = '0';
        customPopup.style.transform = 'none';
    }
}

// Make the custom-popup draggable
const popupHeader = document.getElementById('popup-header-arp');
let isDragging = false;
let offsetX, offsetY;

popupHeader.addEventListener('mousedown', startDragging);
popupHeader.addEventListener('mouseup', stopDragging);
document.addEventListener('mousemove', drag);

function startDragging(e) {
    isDragging = true;
    offsetX = e.clientX - document.getElementById('custom-popup-arp').offsetLeft;
    offsetY = e.clientY - document.getElementById('custom-popup-arp').offsetTop;
}

function stopDragging() {
    isDragging = false;
}

function drag(e) {
    if (isDragging) {
        document.getElementById('custom-popup-arp').style.left = e.clientX - offsetX + 'px';
        document.getElementById('custom-popup-arp').style.top = e.clientY - offsetY + 'px';
    }
}

// Resize the custom-popup
const resizeHandle = document.getElementById('resize-handle-arp');
let isResizing = false;
let prevX, prevY;

resizeHandle.addEventListener('mousedown', startResizing);
document.addEventListener('mouseup', stopResizing);
document.addEventListener('mousemove', resize);

function startResizing(e) {
    isResizing = true;
    prevX = e.clientX;
    prevY = e.clientY;
}

function stopResizing() {
    isResizing = false;
}

function resize(e) {
    if (isResizing) {
        const customPopup = document.getElementById('custom-popup-arp');
        const width = parseInt(getComputedStyle(customPopup, null).getPropertyValue('width'));
        const height = parseInt(getComputedStyle(customPopup, null).getPropertyValue('height'));

        // Limit resizing to the window dimensions
        const newWidth = Math.max(200, width + e.clientX - prevX);
        const newHeight = Math.max(200, height + e.clientY - prevY);
        customPopup.style.width = newWidth + 'px';
        customPopup.style.height = newHeight + 'px';

        prevX = e.clientX;
        prevY = e.clientY;
    }
}

// Minimize the tiny-window
function minimizeTinyWindow() {
    document.getElementById('tiny-window-arp').style.display = 'none';
}

// Maximize the tiny-window
function maximizeTinyWindow() {
    openCustomPopup();
    document.getElementById('tiny-window-arp').style.display = 'none';
}

// Open the full-screen modal
function openFullScreenModal() {
    // Check if the modal is already open
    if (!$('#largeModal-arp').hasClass('show')) {
        $('#largeModal-arp').modal('show');
    }
}

// Function to handle click event inside the iframe
function handleIframeClick() {
    openFullScreenModal(); // Open the full-screen modal when iframe is clicked
}

// Add event listener to iframe after it's loaded
document.getElementById('tiny-window-body-arp').getElementsByTagName('iframe')[0].onload = function () {
    // Access the iframe content document
    var iframeDoc = this.contentDocument || this.contentWindow.document;
    // Add click event listener to the iframe content
    iframeDoc.body.addEventListener('click', handleIframeClick);
};


window.focus()
window.addEventListener("blur", () => {
    setTimeout(() => {
        if (document.activeElement.tagName === "IFRAME") {
            $('#largeModal-arp').modal('show');
        }
    });
}, { once: true });
