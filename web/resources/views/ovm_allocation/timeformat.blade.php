<script>
    function convertTimeFormat(input) {
        var inputValue = input;
        var timeParts = inputValue.split(':');
        let hours = parseInt(timeParts[0]);
        var minutes = timeParts[1];
        let meridian = '';

        if (hours >= 12) {
            meridian = ' PM';
            if (hours > 12) {
                hours -= 12;
            }
        } else {
            meridian = ' AM';
            if (hours === 0) {
                hours = 12;
            }
        }

        var formattedTime = `${hours}:${minutes}${meridian}`;
        return formattedTime;
    }
</script>