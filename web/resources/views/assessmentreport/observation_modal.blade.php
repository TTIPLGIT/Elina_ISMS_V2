<style>
    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50%;
        height: 400px;
        background-color: #ffffff;
        border: 1px solid #ccc;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        z-index: 9999;
        overflow: hidden;
    }

    .popup-header {
        background-color: #f0f0f0;
        padding: 5px;
        cursor: move;
        user-select: none;
    }

    .popup-header-btns {
        float: right;
    }

    .popup-header-btns button {
        margin-left: 5px;
        cursor: pointer;
    }

    .popup-body {
        height: calc(100% - 30px);
        overflow-y: auto;
        padding: 10px;
        width: 100%;
    }

    .table-responsive {
        margin-top: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 8px;
        border: 1px solid #ccc;
        text-align: left;
    }

    /* Resize handle */
    #resize-handle {
        width: 10px;
        height: 10px;
        background: #ccc;
        position: absolute;
        right: 0;
        bottom: 0;
        cursor: se-resize;
    }

    body.dragging {
        user-select: none;
    }

    .copy-icon {
        margin-left: 8px;
        cursor: pointer;
        font-size: 14px;
        color: #555;
        display: inline-block;
        transition: color 0.2s;
    }

    .copy-icon:hover {
        color: #000;
    }
</style>

<div id="popup" class="popup">
    <div class="popup-header" id="header">
        Activity Observation Notes
        <div class="popup-header-btns">
            <button onclick="closePopup()" title="Close popup">x</button>
        </div>
    </div>

    <div class="popup-body">
        <select id="firstSelect" onchange="activityFilter()">
            <option value="all">Activity Set</option>
        </select>
        <button onclick="copySelectedObservations()" style="margin-top: 10px;">Copy Selected</button>



        <div id="toast" style="visibility: hidden;min-width: 160px;background-color: #333;color: #fff;text-align: center;border-radius: 4px;
            padding: 8px 16px;position: fixed;z-index: 10000;left: 50%;bottom: 30px;transform: translateX(-50%);font-size: 14px;opacity: 0;transition: opacity 0.3s ease, bottom 0.3s ease;">
            Copied to clipboard!
        </div>

        <div class="table-responsive">
            <table class="table table-bordered card-body">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)" title="Select All" /></th>
                        <th>Activity Set</th>
                        <th>Activity Description</th>
                        <th>Observation</th>
                    </tr>
                </thead>
                <tbody id="activity-table">
                    <!-- <tr data-activity-set="asd">
                        <td><input type="checkbox" class="row-checkbox" /></td>
                        <td>asd</td>
                        <td>asdadf</td>
                        <td>
                            <span class="observation-text">asdadf</span>
                            <span class="copy-icon" onclick="copyObservation(this)" title="Copy"><i class="fa fa-clipboard" aria-hidden="true"></i></span>
                        </td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    </div>

    <div id="resize-handle"></div>
</div>

<script>
    const popup = document.getElementById('popup');
    const header = document.getElementById('header');
    const resizeHandle = document.getElementById('resize-handle');

    function openPopup() {
        popup.style.display = 'block';
        populateSelect();
    }

    function closePopup() {
        popup.style.display = 'none';
    }

    function activityFilter() {
        const selectedSet = document.getElementById('firstSelect').value;
        const rows = document.querySelectorAll('#activity-table tr');

        rows.forEach(row => {
            const activitySet = row.getAttribute('data-activity-set');
            row.style.display = (selectedSet === 'all' || activitySet === selectedSet) ? '' : 'none';
        });
    }

    function populateSelect() {
        const select = document.getElementById('firstSelect');
        const rows = document.querySelectorAll('#activity-table tr');
        const sets = new Set();

        // Clear previous options except "all"
        select.innerHTML = '<option value="all">Activity Set</option>';

        rows.forEach(row => {
            const set = row.getAttribute('data-activity-set');
            if (set) sets.add(set);
        });

        sets.forEach(set => {
            const option = document.createElement('option');
            option.value = set;
            option.textContent = set;
            select.appendChild(option);
        });
    }

    // Drag functionality
    let isDragging = false,
        offsetX, offsetY;

    header.addEventListener('mousedown', function(e) {
        isDragging = true;
        offsetX = e.clientX - popup.offsetLeft;
        offsetY = e.clientY - popup.offsetTop;
        document.body.classList.add('dragging');

        document.addEventListener('mousemove', dragPopup);
        document.addEventListener('mouseup', stopDrag);
    });

    function dragPopup(e) {
        if (isDragging) {
            popup.style.left = `${e.clientX - offsetX}px`;
            popup.style.top = `${e.clientY - offsetY}px`;
        }
    }

    function stopDrag() {
        isDragging = false;
        document.body.classList.remove('dragging');
        document.removeEventListener('mousemove', dragPopup);
    }

    // Resize functionality
    resizeHandle.addEventListener('mousedown', function(e) {
        e.preventDefault();
        window.addEventListener('mousemove', resizePopup);
        window.addEventListener('mouseup', stopResize);
    });

    function resizePopup(e) {
        const newWidth = e.clientX - popup.getBoundingClientRect().left;
        const newHeight = e.clientY - popup.getBoundingClientRect().top;
        popup.style.width = `${newWidth}px`;
        popup.style.height = `${newHeight}px`;
    }

    function stopResize() {
        window.removeEventListener('mousemove', resizePopup);
        window.removeEventListener('mouseup', stopResize);
    }

    function toggleSelectAll(source) {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = source.checked);
    }

    function copySelectedObservations() {
        const checkboxes = document.querySelectorAll('.row-checkbox:checked');
        const observations = [];

        checkboxes.forEach(cb => {
            const row = cb.closest('tr');
            const observation = row.querySelector('.observation-text');
            if (observation) {
                observations.push(observation.textContent.trim());
            }
        });

        if (observations.length === 0) {
            showToast("No observations selected");
            return;
        }

        const combinedText = observations.join('\n\n');
        navigator.clipboard.writeText(combinedText).then(() => {
            showToast("Selected observations copied!");
        }).catch(err => {
            console.error('Bulk copy failed', err);
            showToast("Copy failed");
        });
    }


    function showToast(message) {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.style.visibility = 'visible';
        toast.style.opacity = '1';
        toast.style.bottom = '30px';

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.bottom = '20px';
            setTimeout(() => toast.style.visibility = 'hidden', 300);
        }, 2000);
    }
</script>


<!-- Modal -->
