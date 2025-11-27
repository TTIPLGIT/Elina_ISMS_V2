<style>
    .popover {
        max-width: 350px;
        white-space: normal;
    }

    .popover.bs-popover-right .arrow::before {
        border-right-color: #000;
    }
</style>

<div class="table-responsive" id="table_a{{ $page['page'] }}">
    <table class="table table-bordered card-body">
        <thead>
            <tr>
                <th colspan="4" style="background-color: white !important; color: #141414; text-align: left; border: 1px solid #040404 !important;">
                    {{ $perskills['skill_name'] }}
                    <input type="checkbox" style="float:right" name="switch[]" onclick="handleCheckboxTable(this); handlePageRemovalCheckbox(this)" value="{{ $perskills['skill_id'] }}" class="check">
                </th>
            </tr>
        </thead>
        <tbody id="tablebody_a{{ $page['page'] }}" class="tablebody_a{{ $page['page'] }}_{{ $perskills['skill_id'] }}">
            @foreach($activitys as $activity)
            @if($page['assesment_skill_id'] == $activity['performance_area_id'] && $activity['skill_type'] == 2 && $activity['skill_id'] == $perskills['skill_id'])
            <tr class="firstrow" style="{{ $activity['isVerified'] == 1 ? 'background-color:#ea5455' : '' }}">
                <td width="30%" style="{{ $activity['isVerified'] == 1 ? 'display: flex; align-items: center; width: 100%;border: #ea5455 !important;' : '' }}">
                    @if($activity['isVerified'] == 1)
                    <i class="fa fa-info-circle text-warning" tabindex="0"
                        data-toggle="popover"
                        data-trigger="hover focus click"
                        data-placement="right"
                        data-content="This activity is not approved by the IS Head and this activity will not reflect in the final report PDF unless the IS Head approves it"
                        aria-describedby="popover">
                    </i>
                    @endif
                    <select class="form-control default observationSelect activitySelect activity_a{{ $page['page'] }}" name="activity[{{ $page['assesment_skill_id'] }}][]">
                        <option value="{{ $activity['activity_id'] }}" selected>{{ $activity['activity_name'] }}</option>
                    </select>
                </td>
                <td width="30%">
                    <select class="form-control default observationSelect" name="observation[{{ $page['assesment_skill_id'] }}][]">
                        @foreach($observations as $observation)
                        <option value="{{ $observation['observation_id'] }}">{{ $observation['observation_name'] }}</option>
                        @endforeach
                    </select>
                </td>
                <td width="30%">
                    <textarea class="observationSelect" style="width: 100%;" id="evidence{{ $activity['activity_id'] }}" name="evidence[{{ $page['assesment_skill_id'] }}][]" oninput="checkCharCount(this)"></textarea>
                </td>
                <td style="display: flex;align-items: center;height: fit-content;">
                    <textarea class="form-control default" name="recommendation[{{ $page['assesment_skill_id'] }}][]" id="recommendation_a{{ $activity['activity_id'] }}" placeholder="Enter recommendation..."></textarea>
                    <a class="btn remove_a" title="Remove" onclick="this.closest('tr').remove()">
                        <i class="fa fa-times"></i>
                    </a>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

    <!-- Recommendation Textarea -->
    <!-- <div class="form-group mt-3">
        <label for="recommendation_a{{ $page['page'] }}"><strong>Recommendation</strong></label>
        <textarea class="form-control" name="recommendation['skills'][{{$perskills['skill_id']}}]" id="recommendation_a{{ $page['page'] }}" rows="4" placeholder="Enter recommendation..."></textarea>
    </div> -->

    <!-- Add Activity Button -->
    <div class="d-flex justify-content-center align-items-center">
        <button type="button" class="btn btn-success mt-2"
            onclick="addNewRowWithInputA({{ $page['page'] }}, {{ $page['assesment_skill_id'] }}, {{ $perskills['skill_id'] }})">
            Add Activity
        </button>
    </div>
</div>

<script>
    $(function() {
        $('[data-toggle="popover"]').popover({
            trigger: 'hover focus click'
        });
    });
</script>

<script>
    const allActivities = @json($activitys);
    const observations = @json($observations);

    function normalizeName(name) {
        return name.trim().toLowerCase().replace(/s$/, '');
    }

    function checkCharCount(textarea) {
        const maxLength = 1500;
        if (textarea.value.length > maxLength) {
            textarea.value = textarea.value.slice(0, maxLength);
            alert("Maximum character limit of 1500 exceeded.");
        }
    }

    function getObservationOptions() {
        return observations.map(o => `<option value="${o.observation_id}">${o.observation_name}</option>`).join('');
    }

    function addNewRowWithInputA(pageId, assesmentSkillId, skillId) {
        if (removedPages.includes(String(pageId))) {
            Swal.fire('Warning', `The respective page has been removed. You can’t add a new activity to this page.`, 'warning');
            return false;
        }
        if (pagesToRemove.includes(String('skill2-' + skillId))) {
            Swal.fire('Warning', `The respective page has been removed. You can’t add a new activity to this page.`, 'warning');
            return false;
        }
        const filteredActivities = allActivities.filter(act =>
            act.performance_area_id == assesmentSkillId &&
            act.skill_type == 2 &&
            act.skill_id == skillId
        );

        const tbody = document.getElementById('tablebody_a' + pageId);
        const existingNames = Array.from(tbody.querySelectorAll('select.activitySelect option[selected]'))
            .map(opt => opt.textContent.trim().toLowerCase());

        const datalistOptions = filteredActivities
            .filter(act => !existingNames.includes(act.activity_name.trim().toLowerCase()))
            .map(act => `<option value="${act.activity_name}">`)
            .join('');

        Swal.fire({
            title: 'Enter Activity Name',
            html: `
                <input list="activityListA" id="swal-input-a" class="swal2-input" placeholder="Type or select activity">
                <datalist id="activityListA">${datalistOptions}</datalist>
            `,
            showCancelButton: true,
            focusConfirm: false,
            preConfirm: () => {
                const input = document.getElementById('swal-input-a');
                if (!input.value.trim()) {
                    Swal.showValidationMessage('Activity name is required');
                    return false;
                }
                return input.value.trim();
            }
        }).then(result => {
            if (result.isConfirmed) {
                const typedName = result.value;
                const normalizedTyped = normalizeName(typedName);
                const existingNormalized = existingNames.map(n => normalizeName(n));

                if (existingNormalized.includes(normalizedTyped)) {
                    Swal.fire('Duplicate Entry', `"${typedName}" is already added to the table.`, 'warning');
                    return;
                }

                const existsInDB = filteredActivities.some(act => normalizeName(act.activity_name) === normalizedTyped);

                if (existsInDB) {
                    insertRowToTableA(pageId, assesmentSkillId, skillId, typedName, '');
                } else {
                    Swal.fire({
                        title: `Are you sure you want to submit?`,
                        html: `It'll go to the IS Head, and you can't edit it after submission.`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Confirm',
                    }).then(confirmResult => {
                        if (confirmResult.isConfirmed) {
                            add_new_activity(assesmentSkillId, typedName, skillId, pageId, 'skill2');
                            // insertRowToTableA(pageId, assesmentSkillId, skillId, typedName, '');
                        }
                    });
                }
            }
        });
    }

    function insertRowToTableA(pageId, assesmentSkillId, skillId, activityName, activityId = '') {
        const tbody = document.querySelector('.tablebody_a' + pageId + '_' + skillId);
        const newRow = document.createElement('tr');
        newRow.classList.add('firstrow');

        newRow.innerHTML = `
            <td width="30%">
                <select class="form-control default observationSelect activitySelect activity_a${pageId}" name="activity[${assesmentSkillId}][]">
                    <option value="${activityId}" selected>${activityName}</option>
                </select>
            </td>
            <td width="30%">
                <select class="form-control default observationSelect" name="observation[${assesmentSkillId}][]">
                    ${getObservationOptions()}
                </select>
            </td>
            <td width="30%">
                <textarea class="observationSelect" style="width: 100%;" oninput="checkCharCount(this)" name="evidence[${assesmentSkillId}][]"></textarea>
            </td>
            <td style="display: flex;align-items: center;height: fit-content;">
                <textarea class="form-control default" name="recommendation[ ${assesmentSkillId} ][]" id="recommendation_a${activityId}" placeholder="Enter recommendation..."></textarea>
                <a class="btn remove_a" title="Remove" onclick="this.closest('tr').remove()">
                    <i class="fa fa-times"></i>
                </a>
            </td>
        `;

        tbody.appendChild(newRow);
    }

    function handleCheckboxTable(checkbox) {
        const skillId = checkbox.value;
        const checked = checkbox.checked;
        // console.log(`Skill ID: ${skillId}, Checked: ${checked}`);
        // You can toggle enabling/disabling the entire section here
    }

    var pagesToRemove = [];
    function handlePageRemovalCheckbox(pageCheckbox) {
        var pageValue = pageCheckbox.value;
        var pageIndex = pagesToRemove.indexOf('skill2-' + pageValue);

        if (pageCheckbox.checked) {
            if (pageIndex === -1) {
                pagesToRemove.push('skill2-' + pageValue);
            }
        } else {
            if (pageIndex !== -1) {
                pagesToRemove.splice(pageIndex, 1);
            }
        }
    }
</script>