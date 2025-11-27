<script>
    function add_new_sub_activity(tbody, assessmentId, subSkillId, typedName) {
        // console.log(tbody, assessmentId, subSkillId, typedName);
        $.ajax({
            url: "{{ url('/store/new/assessment/skill') }}",
            type: 'POST',
            data: {
                'performanceAreaId': assessmentId,
                'typedName': typedName,
                // 'skillId': skillId,
                'subSkillId': subSkillId,
                _token: '{{csrf_token()}}'
            }
        }).done(function(data) {
            var activityID = data;
            console.log(activityID);
            insertRow(tbody, assessmentId, subSkillId, typedName, activityID);
            // insertRow(tbody, assessmentId, skillId, typedName, '');
        })
    }

    function add_new_activity(assesmentSkillId, typedName, skillId, pageId, skill = null) {

        $.ajax({
            url: "{{ url('/store/new/assessment/skill') }}",
            type: 'POST',
            data: {
                'performanceAreaId': assesmentSkillId,
                'typedName': typedName,
                'skillId': skillId,
                _token: '{{csrf_token()}}'
            }
        }).done(function(data) {
            var activityID = data;
            if (skill == "skill2") {
                insertRowToTableA(pageId, assesmentSkillId, skillId , typedName, activityID);
            } else {
                insertRowToTable(pageId, assesmentSkillId, typedName, activityID);
            }
        })
    }
</script>