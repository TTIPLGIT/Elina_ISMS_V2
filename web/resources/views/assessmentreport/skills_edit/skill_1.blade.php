<div style="font-weight:bold;font-style: italic;font-size: 15px;display: flex;align-items: center;">
    <p style="color:red">* </p> &nbsp; Note: Text in the 'Evidence' column not to be exceeded more than 1500 characters.
</div>
<div id="table{{$page['page']}}">
    <div class="table-responsive">
        <table class="table table-bordered card-body" style="border-spacing: 0px;border-collapse: collapse;">
            <thead>
                <tr>
                    <th width="30%">{{ $perskills['skill_name'] ?? $page['tab_name'] }}</th>
                    <th width="30%">Observation</th>
                    <th class="required" width="30%">Evidence</th>
                    <th class="required" width="10%">Recomendation</th>
                </tr>
            </thead>
            <tbody id="tablebody{{$page['page']}}">

                @foreach($details as $detail)
                @if($page['assessment_skill'] == $detail['performance_area_id'])
                <tr style="{{ in_array($detail['activity_name'], $verifiedActivities) ? 'background-color:#ea5455' : '' }}">
                    <td width="30%" style="{{ in_array($detail['activity_name'], $verifiedActivities) ? 'display: flex; align-items: center; width: 100%;border: #ea5455 !important;' : '' }}">
                        @if(in_array($detail['activity_name'], $verifiedActivities))
                        <i class="fa fa-info-circle text-warning" tabindex="0"
                            data-toggle="popover"
                            data-trigger="hover focus click"
                            data-placement="right"
                            data-content="This activity is not approved by the IS Head and this activity will not reflect in the final report PDF unless the IS Head approves it"
                            aria-describedby="popover">
                        </i>
                        @endif
                        <select class="form-control default observationSelect activitySelect Ractivity activity{{ $page['page'] }}" name="activity[{{ $page['assessment_skill'] }}][]">
                            @foreach ($activitys as $activity)
                            @if ($page['assessment_skill'] == $activity['performance_area_id'] && $activity['skill_id'] == $perskills['skill_id'] && $activity['skill_type'] == 1 && $detail['activity_name'] == $activity['activity_id'])
                            <option value="{{ $activity['activity_id'] }}" selected>{{ $activity['activity_name'] }}</option>
                            @endif
                            @endforeach
                        </select>
                    </td>

                    <td width="30%">
                        <select class="form-control default observationSelect" name="observation[{{$page['assessment_skill']}}][]">
                            @foreach ($observations as $observation)
                            <option value="{{ $observation['observation_id'] }}" {{ $detail['observation_name'] == $observation['observation_id'] ? 'selected' : '' }}>
                                {{ $observation['observation_name'] }}
                            </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <textarea style="width: 100% !important;" class="observationSelect addProducttext{{$page['page']}}" name="evidence[{{$page['assessment_skill']}}][]" oninput="checkCharCount(this)">{{$detail['evidence']}}</textarea>
                    </td>
                    <td style="display: flex;align-items: center;height: fit-content;">
                        <textarea style="width: 100% !important;" class="form-control default" name="recommendation[{{$page['assessment_skill']}}][]">{{$detail['recommendation']}}</textarea>
                        <a class="btn remove removeR" order="{{$page['page']}}" title="Add" id="removeProduct"><i class="fa fa-times" order="{{$page['page']}}"></i></a>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center align-items-center">
    <button type="button" class="btn btn-success col-4" onclick="addNewRowWithInput({{ $page['page'] }}, {{ $page['assessment_skill'] }}, {{ $perskills['skill_id'] }})">
        Add Activity
    </button>
</div>
@php
$skill_id = $page['assessment_skill'] ?? 'null';
$skill_type = $perskills['skill_type'];
$recommendation = $recommendation_lookup[$skill_id][$skill_type] ?? '';
@endphp

<!-- Recommendation Field -->
<!-- <div class="form-group mt-3">
    <label for="recommendation{{ $page['page'] }}"><strong>Recommendation</strong></label>
    <textarea class="form-control" name="recommendation['motor'][{{ $page['assessment_skill'] }}]" id="recommendation{{ $page['page'] }}" rows="4" placeholder="Enter recommendation for this skill area...">{{ $recommendation }}</textarea>
</div> -->

<script>
    // Normalize names for comparison: lowercase, trim, remove trailing 's'
    function normalizeName(name) {
        return name.trim().toLowerCase().replace(/s$/, '');
    }

    function addNewRowWithInput(pageId, assesmentSkillId, skillId) {

        if (removedPages.includes(String(pageId))) {
            Swal.fire('Warning', `The respective page has been removed. You can’t add a new activity to this page.`, 'warning');
            // console.log(`${pageId} is already in removedPages`);
            return false;
        }
        
        const allActivities = @json($activitys);

        // Filter activities by performance area & skill
        const filteredActivities = allActivities.filter(act =>
            act.performance_area_id == assesmentSkillId &&
            act.skill_type == 1 &&
            act.skill_id == skillId
        );

        // Get activity names already in table (case-insensitive)
        const tbody = document.getElementById('tablebody' + pageId);
        const existingNamesInTable = Array.from(tbody.querySelectorAll('select.activitySelect option[selected]'))
            .map(opt => opt.textContent.trim().toLowerCase());

        // Build datalist options excluding existing names in table
        const datalistOptions = filteredActivities
            .filter(act => !existingNamesInTable.includes(act.activity_name.trim().toLowerCase()))
            .map(act => `<option value="${act.activity_name}">`)
            .join('');

        Swal.fire({
            title: 'Enter Activity Name',
            html: `
                <input list="activityList" id="swal-input" class="swal2-input" autocomplete="off" placeholder="Type or select activity">
                <datalist id="activityList">
                    ${datalistOptions}
                </datalist>
            `,
            focusConfirm: false,
            showCancelButton: true,
            preConfirm: () => {
                const input = document.getElementById('swal-input');
                if (!input.value.trim()) {
                    Swal.showValidationMessage('Activity name is required');
                    return false;
                }
                return input.value.trim();
            }
        }).then(result => {
            if (result.isConfirmed) {
                const typedName = result.value;

                // Check DB existence normalized
                const existsInDB = filteredActivities.some(act =>
                    normalizeName(act.activity_name) === normalizeName(typedName)
                );

                // Normalize existing names in table for duplicate check
                const existingNormalized = existingNamesInTable.map(n => normalizeName(n));

                if (existingNormalized.includes(normalizeName(typedName))) {
                    Swal.fire('Duplicate Entry', `"${typedName}" is already added to the table (or very similar).`, 'warning');
                    return;
                }

                if (existsInDB) {
                    insertRowToTable(pageId, assesmentSkillId, typedName, '');
                } else {
                    Swal.fire({
                        title: `Are you sure you want to submit?`,
                        html: `It'll go to the IS Head, and you can't edit it after submission.`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Confirm',
                    }).then(confirmResult => {
                        if (confirmResult.isConfirmed) {
                            // 
                            add_new_activity(assesmentSkillId, typedName, skillId, pageId);
                            // 
                            // insertRowToTable(pageId, assesmentSkillId, typedName, '');
                        }
                    });
                }
            }
        });
    }

    function insertRowToTable(pageId, assesmentSkillId, activityName, activityId = '') {
        const tbody = document.getElementById('tablebody' + pageId);
        const newRow = document.createElement('tr');
        newRow.classList.add('firstrow');

        newRow.innerHTML = `
            <td width="30%">
                <select class="form-control default observationSelect activitySelect my-select activity${pageId}" name="activity[${assesmentSkillId}][]">
                    <option value="${activityId}" selected>${activityName}</option>
                </select>
            </td>
            <td width="30%">
                <select class="form-control default observationSelect" name="observation[${assesmentSkillId}][]">
                    ${getObservationOptions()}
                </select>
            </td>
            <td>
                <textarea style="width: 100% !important;" class="observationSelect" oninput="checkCharCount(this)" name="evidence[${assesmentSkillId}][]"></textarea>
            </td>
            <td style="display: flex; align-items: center;">
                <textarea class="form-control default" name="recommendation[${assesmentSkillId}][]" id="recommendation${activityId}" placeholder="Enter recommendation for this skill area..."></textarea>
                <a class="btn remove" title="Remove" onclick="this.closest('tr').remove()">
                    <i class="fa fa-times"></i>
                </a>
            </td>
        `;
        tbody.appendChild(newRow);
    }

    function getObservationOptions() {
        const observations = @json($observations);
        return observations.map(o => `<option value="${o.observation_id}">${o.observation_name}</option>`).join('');
    }

    function checkCharCount(textarea) {
        const maxLength = 1500;
        if (textarea.value.length > maxLength) {
            textarea.value = textarea.value.slice(0, maxLength);
            alert("Maximum character limit of 1500 exceeded.");
        }
    }
</script>