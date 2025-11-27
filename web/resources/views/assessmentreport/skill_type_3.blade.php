<style>
    .popover {
        max-width: 350px;
        white-space: normal;
    }

    .popover.bs-popover-right .arrow::before {
        border-right-color: #000;
    }
</style>
<div style="font-weight:bold;font-style: italic;font-size: 15px;display: flex;align-items: center;">
    <p style="color:red">* </p> &nbsp; Note: Text in the 'Evidence' column not to be exceeded more than 1500 characters.
</div>

<div id="table{{ $page['page'] }}">
    <div class="table-responsive">
        <table class="table table-bordered card-body">
            <thead>
                <tr>
                    <th width="30%">{{ $perskills['skill_name'] ?? $page['tab_name'] }}</th>
                    <th width="30%">Observation</th>
                    <th width="30%">Evidence</th>
                    <th class="required" width="10%">
                        Recommendation
                        <input type="checkbox" style="float:right" onclick="handleCheckboxTable(this)" name="switch[]" value="{{ $perskills['skill_id'] }}" class="check">
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@foreach($subskill as $sskill)
@if($page['assesment_skill_id'] == $sskill['performance_area_id'] && $sskill['primary_skill_id'] == $perskills['skill_id'])
<div class="table-responsive" id="table_b{{ $sskill['skill_id'] }}">
    <table class="table table-bordered card-body">
        <thead>
            <tr>
                <th colspan="4" style="background-color: white !important;color: #141414;text-align: left;border: 1px solid #040404 !important;">
                    {{ $sskill['skill_name'] }}
                    <input type="checkbox" style="float:right" onclick="handleCheckboxTable(this); handlePageRemovalCheckboxA(this)" name="switch2[]" value="{{ $sskill['skill_id'] }}" class="check">
                </th>
            </tr>
        </thead>
        <tbody id="tablebody_b{{ $sskill['skill_id'] }}">
            @foreach($activitys as $activity)
            @if($sskill['skill_id'] == $activity['sub_skill'])
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
                    <select class="form-control default observationSelect activitySelect activity_c{{ $sskill['skill_id'] }}" name="activity[{{ $page['assesment_skill_id'] }}][]">
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
                    <textarea style="width: 100% !important;" class="observationSelect" id="evidence{{ $activity['activity_id'] }}" oninput="checkCharCount(this)" name="evidence[{{ $page['assesment_skill_id'] }}][]"></textarea>
                </td>
                <td style="display: flex;align-items: center;height: fit-content;">
                    <!-- <textarea style="width: 100% !important;" class="observationSelect" id="evidence{{ $activity['activity_id'] }}" oninput="checkCharCount(this)" name="evidence[{{ $page['assesment_skill_id'] }}][]"></textarea> -->
                    <textarea class="form-control default" name="recommendation[{{ $page['assesment_skill_id'] }}][]" id="recommendation{{ $activity['activity_id'] }}" placeholder="Enter recommendation for this skill area..."></textarea>
                    <a class="btn remove_b" order="{{ $page['page'] }}" table="{{ $sskill['skill_id'] }}" title="Remove" id="removeProduct">
                        <i class="fa fa-times" order="{{ $page['page'] }}" table="{{ $sskill['skill_id'] }}"></i>
                    </a>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">
                    <button type="button" class="btn btn-sm btn-success add-row-btn" data-skill-id="{{ $sskill['skill_id'] }}" data-page-id="{{ $page['page'] }}" data-assessment-id="{{ $page['assesment_skill_id'] }}">
                        Add Activity
                    </button>
                </td>
            </tr>
        </tfoot>

    </table>

    <!-- Recommendation Field -->
    <!-- <div class="form-group mt-3">
        <label for="recommendation{{ $page['page'] }}"><strong>Recommendation</strong></label>
        <textarea class="form-control" name="recommendation['sub_skills'][{{$sskill['skill_id']}}]" id="recommendation{{ $page['page'] }}" rows="4" placeholder="Enter recommendation for this skill area..."></textarea>
    </div> -->
</div>
@endif
@endforeach
<!-- Test End -->



<script type="application/json" id="all-activities-data">
    @json($activitys)
</script>
<script type="application/json" id="observations-data">
    @json($observations)
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const allActivities = JSON.parse(document.getElementById('all-activities-data').textContent);
        const observations = JSON.parse(document.getElementById('observations-data').textContent);

        // Global character limit check for textarea
        function checkCharCount(textarea) {
            const maxLength = 1500;
            if (textarea.value.length > maxLength) {
                textarea.value = textarea.value.slice(0, maxLength);
                alert("Maximum character limit of 1500 exceeded.");
            }
        }

        // Get observation options HTML
        function getObservationOptions() {
            return observations.map(o => `<option value="${o.observation_id}">${o.observation_name}</option>`).join('');
        }

        // Normalize names (trim, lower case, collapse spaces)
        function normalizeName(name) {
            return name.trim().toLowerCase().replace(/\s+/g, ' ');
        }

        document.body.addEventListener('click', function(event) {
            const btn = event.target.closest('.add-row-btn');
            if (!btn) return;
            // console.log('btn.dataset', btn.dataset);
            const skillId = btn.dataset.skillId;
            const assessmentId = btn.dataset.assessmentId;
            const pageId = btn.dataset.pageId;

            if (removedPages.includes(String(pageId))) {
                Swal.fire('Warning', `The respective page has been removed. You can’t add a new activity to this page.`, 'warning');
                return false;
            }

            if (pagesToRemove.includes(String('skill3-' + skillId))) {
                Swal.fire('Warning', `The respective page has been removed. You can’t add a new activity to this page.`, 'warning');
                return false;
            }

            const tbody = document.getElementById('tablebody_b' + skillId);
            if (!tbody) {
                console.error(`Table body with id 'tablebody_b${skillId}' not found`);
                return;
            }

            // Filter activities related to this skill and assessment
            const filteredActivities = allActivities.filter(act =>
                act.performance_area_id == assessmentId &&
                act.sub_skill == skillId
            );

            // Get all existing selected activity names in this tbody, normalized
            const existingNames = Array.from(tbody.querySelectorAll('select.activitySelect'))
                .map(select => {
                    const opt = select.selectedOptions[0];
                    return opt ? normalizeName(opt.textContent) : '';
                })
                .filter(name => name !== '');

            // console.log('Existing Activity Names:', existingNames);

            // Prepare datalist options for new entry input
            const datalistOptions = filteredActivities
                .filter(act => !existingNames.includes(normalizeName(act.activity_name)))
                .map(act => `<option value="${act.activity_name}">`)
                .join('');

            Swal.fire({
                title: 'Enter Activity Name',
                html: `
                    <input list="activityList" id="swal-input" class="swal2-input" placeholder="Type or select activity">
                    <datalist id="activityList">${datalistOptions}</datalist>
                `,
                showCancelButton: true,
                focusConfirm: false,
                preConfirm: () => {
                    const input = document.getElementById('swal-input');
                    if (!input.value.trim()) {
                        Swal.showValidationMessage('Activity name is required');
                        return false;
                    }
                    return input.value.trim();
                }
            }).then(result => {
                if (!result.isConfirmed) return;

                const typedName = result.value;
                const normalizedTyped = normalizeName(typedName);

                // console.log('Typed Activity Name:', `"${typedName}"`, 'Normalized:', `"${normalizedTyped}"`);
                // console.log('Existing Normalized Names:', existingNames);

                // Duplicate check among existing rows
                if (existingNames.includes(normalizedTyped)) {
                    Swal.fire('Duplicate Entry', `"${typedName}" is already added.`, 'warning');
                    return;
                }

                // Check if typed activity exists in DB filtered activities
                const existsInDB = filteredActivities.some(act => normalizeName(act.activity_name) === normalizedTyped);

                if (existsInDB) {
                    insertRow(tbody, assessmentId, skillId, typedName, '');
                } else {
                    Swal.fire({
                        title: `Are you sure you want to submit?`,
                        html: `It'll go to the IS Head, and you can't edit it after submission.`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Confirm',
                    }).then(confirmResult => {
                        if (confirmResult.isConfirmed) {
                            // add_new_sub_activity(tbody, assessmentId, skillId, typedName);
                            $.ajax({
                                url: "{{ url('/store/new/assessment/skill') }}",
                                type: 'POST',
                                data: {
                                    'performanceAreaId': assessmentId,
                                    'typedName': typedName,
                                    // 'skillId': skillId,
                                    'subSkillId': skillId,
                                    _token: '{{csrf_token()}}'
                                }
                            }).done(function(data) {
                                var activityID = data;
                                // console.log("activityID", activityID);
                                insertRow(tbody, assessmentId, skillId, typedName, activityID);
                                // insertRow(tbody, assessmentId, skillId, typedName, '');
                            })
                        }
                    });
                }
            });
        });

        function insertRow(tbody, assessmentId, skillId, activityName, activityId = '') {
            const newRow = document.createElement('tr');
            newRow.classList.add('firstrow');

            newRow.innerHTML = `
                <td width="30%">
                    <select class="form-control default observationSelect activitySelect activity_c${skillId}" name="activity[${assessmentId}][]">
                        <option value="${activityId}" selected="selected">${activityName}</option>
                    </select>
                </td>
                <td width="30%">
                    <select class="form-control default observationSelect" name="observation[${assessmentId}][]">
                        ${getObservationOptions()}
                    </select>
                </td>
                <td>
                    <textarea style="width: 100% !important;" class="observationSelect" oninput="checkCharCount(this)" name="evidence[${assessmentId}][]"></textarea>
                </td>
                <td style="display: flex; align-items: center; height: fit-content;">
                    <textarea class="form-control default" name="recommendation[${assessmentId}][]" id="recommendation${activityId}" placeholder="Enter recommendation for this skill area..."></textarea>
                    <a class="btn remove_b" title="Remove" onclick="this.closest('tr').remove()">
                        <i class="fa fa-times"></i>
                    </a>
                </td>
            `;

            tbody.appendChild(newRow);
        }

        // Expose checkCharCount globally since called inline in HTML
        window.checkCharCount = checkCharCount;
    });

    function handlePageRemovalCheckboxA(pageCheckbox) {
        var pageValue = pageCheckbox.value;
        var pageIndex = pagesToRemove.indexOf('skill3-' + pageValue);

        if (pageCheckbox.checked) {
            if (pageIndex === -1) {
                pagesToRemove.push('skill3-' + pageValue);
            }
        } else {
            if (pageIndex !== -1) {
                pagesToRemove.splice(pageIndex, 1);
            }
        }
    }
</script>