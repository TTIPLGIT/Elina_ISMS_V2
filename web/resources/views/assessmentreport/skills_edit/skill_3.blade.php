<!--  -->
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
                    <th class="required" width="30%">
                        Evidence
                    </th>
                    <th width="10%">
                        Recommendation
                        <input type="checkbox" style="float:right" name="switch[]" value="{{ $perskills['skill_id'] }}" class="check checkAll" onclick="handleCheckboxTable(this);" @if(in_array($perskills['skill_id'], explode(',', $report['switch']))) checked @endif>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Sa -->
@php $j= array() ; $sj= array() ; $ssj= array() ; @endphp
@foreach($subskill as $sskill)
@if($page['assessment_skill'] == $sskill['performance_area_id'] && $sskill['primary_skill_id'] == $perskills['skill_id'])



@foreach($details3 as $detail)
@if($detail['performance_area_id'] == $sskill['performance_area_id'])

<!--  -->
@php $fid = $detail['activity_name'] @endphp

@php $f = 0; array_push($j , $detail['activity_name']); array_push($sj , $sskill['skill_id']); @endphp
<div class="table-responsive" id="table_b{{$sskill['skill_id']}}">
    <table class="table table-bordered card-body" style="border-spacing: 0px;border-collapse: collapse;">
        <thead>
            <tr>
                <th colspan="4" style="background-color: white !important;color: #141414;text-align: left;border: 1px solid #040404 !important;">{{$sskill['skill_name']}}<input type="checkbox" style="float:right" name="switch2[]" value="{{$sskill['skill_id']}}" class="check checkAll{{$sskill['primary_skill_id']}}" onclick="handleCheckboxTable(this); handlePageRemovalCheckboxA(this)" @if(in_array($sskill['skill_id'] , explode(',',$report['switch2']))) checked @endif><!--4--></th>
            </tr>
        </thead>
        <tbody id="tablebody_b{{$sskill['skill_id']}}" class="pageno_c{{$page['page']}}">
            @foreach($details3 as $detail)
            @php $looppasstab3 = 0 @endphp
            @foreach($activitys as $activity)
            @if($sskill['skill_id'] == $activity['sub_skill'])
            @if( $detail['activity_name'] == $activity['activity_id'] )
            @php $looppasstab3 = 1 @endphp
            @endif
            @endif
            @endforeach
            @if($looppasstab3 == 1)
            <tr class="firstrow">
                <td width="30%">
                    <select class="form-control default Ractivity_c observationSelect activitySelect activity_c{{$sskill['skill_id']}}" name="activity[{{$page['assessment_skill']}}][]">

                        @php $fo = 0;@endphp
                        @foreach($activitys as $activity)
                        @if($sskill['skill_id'] == $activity['sub_skill'])
                        @if( $detail['activity_name'] == $activity['activity_id'] )
                        @php $f = 1; $fo = 1; array_push($ssj , $detail['activity_name']);@endphp
                        <option value="{{$activity['activity_id']}}" selected>{{$activity['activity_name']}}</option>

                        @endif
                        @endif
                        @endforeach
                    </select>
                </td>
                <td width="30%">
                    <select class="form-control default observationSelect" name="observation[{{$page['assessment_skill']}}][]">
                        @foreach($observations as $observation)
                        @if( $detail['observation_name'] == $observation['observation_id'] && $fo == 1 )
                        <option value="{{$observation['observation_id']}}" selected>{{$observation['observation_name']}}</option>
                        @else
                        <option value="{{$observation['observation_id']}}">{{$observation['observation_name']}}</option>
                        @endif
                        @endforeach
                    </select>
                </td>
                <td width="30%">
                    @if($fo == 1)
                    <textarea style="width: 100% !important;" class="observationSelect addProducttext_b{{$sskill['skill_id']}}" name="evidence[{{$page['assessment_skill']}}][]" oninput="checkCharCount(this)">{{$detail['evidence'] }}</textarea>
                    @else
                    <textarea style="width: 100% !important;" class="observationSelect addProducttext_b{{$sskill['skill_id']}}" name="evidence[{{$page['assessment_skill']}}][]" oninput="checkCharCount(this)"></textarea>
                    @endif
                </td>
                <td style="display: flex;align-items: center;height: fit-content;">
                    <textarea class="form-control default" name="recommendation[{{$page['assessment_skill']}}][]" id="recommendation[{{$page['assessment_skill']}}][]" placeholder="Enter recommendation for this skill area...">{{$detail['recommendation'] }}</textarea>
                    <a class="btn remove_b removeR" order="{{$page['page']}}" table="{{$sskill['skill_id']}}" title="Add" id="removeProduct"><i class="fa fa-times" order="{{$page['page']}}" table="{{$sskill['skill_id']}}"></i></a>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">
                    <button type="button" class="btn btn-success add-row-btn col-4" data-skill-id="{{ $sskill['skill_id'] }}" data-assessment-id="{{ $page['assessment_skill'] }}" data-page-id="{{ $page['page'] }}">
                        Add Activity
                    </button>
                </td>
            </tr>
        </tfoot>
    </table>
    @php
    $skill_id = $sskill['skill_id'] ?? 'null';
    $skill_type = $perskills['skill_type'];
    $recommendation = $recommendation_lookup[$skill_id][$skill_type] ?? '';
    @endphp
    <!-- Recommendation Field -->
    <!-- <div class="form-group mt-3">
        <label for="recommendation{{ $page['page'] }}"><strong>Recommendation</strong></label>
        <textarea class="form-control" name="recommendation['sub_skills'][{{$sskill['skill_id']}}]" id="recommendation{{ $page['page'] }}" rows="4" placeholder="Enter recommendation for this skill area...">{{$recommendation}}</textarea>
    </div> -->
</div>
@if($f = 1) @break @endif
<!--  -->

@endif
@endforeach


@endif
@endforeach



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
                        confirmButtonText: 'Yes, add it',
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
                                // console.log("activityID",activityID);
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
                <td width="30%">
                    <textarea style="width: 100% !important;" class="observationSelect" oninput="checkCharCount(this)" name="evidence[${assessmentId}][]"></textarea>
                </td>
                <td style="display: flex;align-items: center;height: fit-content;">
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

    function handleCheckboxTableAll(mainCheckbox) {

        const primarySkillId = mainCheckbox.value;
        const subSkillCheckboxes = document.querySelectorAll(
            '.checkAll' + primarySkillId
        );

        subSkillCheckboxes.forEach(chk => {

            chk.checked = mainCheckbox.checked;
            const pageValue = chk.value;
            const key = 'skill3-' + pageValue;
            const index = pagesToRemove.indexOf(key);

            if (mainCheckbox.checked) {
                if (index === -1) {
                    pagesToRemove.push(key);
                }
            }
            
            else {
                if (index !== -1) {
                    pagesToRemove.splice(index, 1);
                }
            }

        });

        // console.log("Updated pagesToRemove:", pagesToRemove);
    }
</script>